<?php

namespace App\Listeners;

use App\Contracts\UserUpdateNotifiable;
use App\Events\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserUpdateNotification
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
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        if ($event->user instanceof UserUpdateNotifiable) {
            $event->user->sendUserUpdatedNotification();
        }
    }
}
