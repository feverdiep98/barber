<?php

namespace App\Providers;

use App\Events\BookingSuccess;
use App\Events\CheckUserSwitchStatus;
use App\Events\OrderCancelled;
use App\Events\OrderCompleted;
use App\Events\OrderConfirmed;
use App\Events\OrderSuccessEvent;
use App\Listeners\SendBookingConfirmationEmail;
use App\Listeners\SendCompletedOrderEmail;
use App\Listeners\SendEmailToAdminWhenOrderSuccess;
use App\Listeners\SendEmailToCustomerWhenOrderSuccess;
use App\Listeners\SendOrderCancelledEmail;
use App\Listeners\SendOrderConfirmationEmail;
use App\Listeners\UserSwitchStatusListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        BookingSuccess::class => [
            SendBookingConfirmationEmail::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderSuccessEvent::class => [
            SendEmailToCustomerWhenOrderSuccess::class,
            SendEmailToAdminWhenOrderSuccess::class,
        ],
        OrderConfirmed::class => [
            SendOrderConfirmationEmail::class,
        ],
        OrderCompleted::class => [
            SendCompletedOrderEmail::class,
        ],
        OrderCancelled::class => [
            SendOrderCancelledEmail::class,
        ],
        CheckUserSwitchStatus::class => [
            UserSwitchStatusListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
