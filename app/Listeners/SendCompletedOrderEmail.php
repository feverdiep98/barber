<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Mail\OrderComplete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCompletedOrderEmail
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
    public function handle(OrderCompleted $event): void
    {
        $order = $event->order;

        Mail::to('007phatdiep@gmail.com')->send(new OrderComplete ($order));
    }
}
