<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Mail\OrderCancelled as MailOrderCancelled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderCancelledEmail
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
    public function handle(OrderCancelled $event): void
    {
        $order = $event->order;

        Mail::to('007phatdiep@gmail.com')->send(new MailOrderCancelled ($order));
    }
}
