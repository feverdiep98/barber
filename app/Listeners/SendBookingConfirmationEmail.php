<?php

namespace App\Listeners;

use App\Events\BookingSuccess;
use App\Mail\BookingEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail
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
    public function handle(BookingSuccess $event): void
    {
        $booking = $event->booking;
        Mail::to('007phatdiep@gmail.com')->send(new BookingEmail ($booking));
    }
}
