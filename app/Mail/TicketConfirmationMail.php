<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Ticket Confirmation')
            ->view('emails.ticket_confirmation')
            ->with([
                'eventTitle' => $this->order->event->title,
                'userName'   => $this->order->user->name,
                'ticketId'   => $this->order->id,
                'quantity'   => $this->order->quantity,
                'totalPrice' => $this->order->total_amount,
                'description' => $this->order->event->description,
                'venue'      => $this->order->event->venue,
                'eventDateTime' => $this->order->event->date,
            ]);
    }
}
