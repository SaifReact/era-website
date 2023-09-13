<?php

namespace App\Listeners;

use App\Contracts\UserPasswordChangedNotifiable;
use App\Events\UserPasswordChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserPasswordChangeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserPasswordChanged  $event
     * @return void
     */
    public function handle(UserPasswordChanged $event)
    {
        if ($event->user instanceof UserPasswordChangedNotifiable) {
            $event->user->sendPasswordChangedNotification();
        }
    }
}
