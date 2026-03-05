<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Jobs\SendTicketEmail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Handles booking tickets for an event, including applying a discount code if provided.
     * Calculates the total amount, creates an order in the database, and generates a Stripe Checkout session.
     * Returns a JSON response with the Stripe payment URL and order details for the frontend to redirect the user.
     */
    public function bookEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id'    => 'required|integer|exists:events,id',
            'quantity'    => 'required|integer|min:1',
            'coupon_code' => 'nullable|string',
            'user_id'     => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()], 422);
        }

        $event = Event::findOrFail($request->event_id);
        $quantity = $request->quantity;
        $ticketPrice = $event->ticket_price;
        $initialTotal = $ticketPrice * $quantity;

        $discountCodeId = null;
        $discountAmount = 0;

        if ($request->coupon_code) {
            $coupon = DiscountCode::where('code', $request->coupon_code)->first();

            if (!$coupon) {
                return $this->errorResponse('Invalid coupon code');
            }

            if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
                return $this->errorResponse('Coupon code has expired');
            }

            if ($coupon->single_use) {
                $alreadyUsed = Order::where('user_id', $request->user_id)
                    ->where('discount_code', $coupon->id)
                    ->exists();

                if ($alreadyUsed) {
                    return $this->errorResponse('Coupon code already used by you');
                }
            }

            $discountAmount = ($initialTotal * ($coupon->percentage / 100));
            $discountCodeId = $coupon->id;
        }

        $totalAmount = max(0, $initialTotal - $discountAmount);
        $totalAmountCents = round($totalAmount * 100);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $order = Order::create([
                'user_id'         => $request->user_id,
                'event_id'        => $event->id,
                'total_amount'    => $totalAmount,
                'status'          => 'pending',
                'quantity'        => $quantity,
                'discount_code_id' => $discountCodeId,
            ]);

            $currentUrl = $request->getSchemeAndHttpHost();
            $returnUrl = $request->header('referer') ?? url('/events');

            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($event->currency ?? 'inr'),
                        'unit_amount' => $totalAmountCents,
                        'product_data' => [
                            'name' => "Ticket(s) for {$event->title}",
                            'description' => "{$quantity} tickets. Discount: " . number_format($discountAmount, 2),
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $returnUrl . '?payment=success&session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                'cancel_url'  => $returnUrl . '?payment=cancelled&order_id=' . $order->id,
                'metadata'    => ['order_id' => $order->id],
            ]);

            $order->update(['stripe_session_id' => $checkoutSession->id]);

            return response()->json([
                'status'  => 1,
                'message' => 'Redirect to Stripe to complete payment',
                'checkout_url' => $checkoutSession->url,
                'order_id' => $order->id,
                'stripe_session_id' => $checkoutSession->id
            ], 200);
        } catch (\Exception $e) {
            Log::error("Stripe Checkout Error [User {$request->user_id}]: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    /**
     * Verifies the Stripe payment using the session ID and updates the order status to completed if successful.
     * Dispatches a ticket email to the user and retrieves the order with related user and event details.
     * Returns a JSON response confirming payment success or an error message if verification fails.
     */
    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $sessionId = $request->get('session_id');
            if (!$sessionId) {
                return $this->errorResponse('Missing payment session ID.', 400);
            }

            $session = Session::retrieve($sessionId);
            $orderId = $session->metadata->order_id ?? null;
            $order  = Order::with(['user', 'event'])->find($orderId);

            if ($session->payment_status === 'paid' && $order) {
                if ($order->status === 'pending') {
                    $order->update(['status' => 'completed']);
                    SendTicketEmail::dispatch($order);
                }
                return response()->json([
                    'status'  => 1,
                    'message' => '🎉 Payment successful! Your order is confirmed.',
                    'order'   => $order
                ], 200);
            }
            return $this->errorResponse('Payment not completed or order already processed.', 400);
        } catch (\Exception $e) {
            return $this->errorResponse('Payment verification failed: ' . $e->getMessage(), 500);
        }
    }

    public function paymentCancel()
    {
        return $this->errorResponse('Payment was cancelled. You can try again.');
    }

    private function errorResponse($message, $code = 200)
    {
        return response()->json(['status' => 0, 'message' => $message], $code);
    }
}
