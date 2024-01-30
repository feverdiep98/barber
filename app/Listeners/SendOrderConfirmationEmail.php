<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Mail\OrderConfirmation;

use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderConfirmed $event): void
    {
        $order = $event->order;

        Mail::to('007phatdiep@gmail.com')->send(new OrderConfirmation($order));
    }
}
