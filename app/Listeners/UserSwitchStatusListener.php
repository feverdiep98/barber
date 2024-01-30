<?php

namespace App\Listeners;

use App\Events\CheckUserSwitchStatus;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class UserSwitchStatusListener
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
    public function handle(CheckUserSwitchStatus $event)
    {
        $user = User::find($event->id);

        if ($user) {
            $user->update(['active' => $event->activeState]);
        }
    }
}
