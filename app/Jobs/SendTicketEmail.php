<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\TicketConfirmationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTicketEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        if (!$this->order || !$this->order->user) {
            Log::error('Order or User not found for SendTicketEmail job', ['order' => $this->order]);
            return;
        }

        Mail::to($this->order->user->email)
            ->send(new TicketConfirmationMail($this->order));
    }
}
