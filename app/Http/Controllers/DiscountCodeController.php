<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    /**
     * Validates and creates a new discount code with percentage, expiry date, and single-use flag.
     * Returns a JSON response with the created discount code details if successful.
     * Handles validation errors and responds with appropriate error messages.
     */
    public function createDiscountCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:discount_codes,code|max:50',
            'percentage' => 'required|integer|min:1|max:100',
            'expires_at' => 'required|date',
            'single_use' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()
            ], 422);
        }
        $discountCode = DiscountCode::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expires_at' => $request->expires_at,
            'single_use' => $request->single_use ?? false
        ]);
        return response()->json([
            'status' => 1,
            'message' => 'Discount code created successfully',
            'data' => $discountCode
        ], 201);
    }

    /**
     * Validates and checks a coupon code for a user, ensuring it exists, is not expired, and has not been used if single-use.
     * Calculates the discount amount based on the ticket amount and the coupon percentage.
     * Returns a JSON response indicating success with the discount or failure with an appropriate message.
     */
    public function checkCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'coupon_code' => 'required|string',
            'ticket_amount' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()
            ], 422);
        }

        $coupon = DiscountCode::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid coupon code'
            ], 200);
        }
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json([
                'status' => 0,
                'message' => 'Coupon code has expired'
            ], 200);
        }

        if ($coupon->single_use) {
            $usedByUser = Order::where('user_id', $request->user_id)
                ->where('discount_code', $coupon->id)
                ->exists();

            if ($usedByUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Coupon code already used by you'
                ], 200);
            }
        }
        $totalDiscount = $request->ticket_amount * ($coupon->percentage / 100);
        return response()->json([
            'status' => 1,
            'message' => 'Coupon applied successfully',
            'discount' => $totalDiscount
        ], 200);
    }
}
