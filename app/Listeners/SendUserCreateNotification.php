<?php

namespace App\Listeners;

use App\Contracts\UserCreateNotifiable;
use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserCreateNotification
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        if ($event->user instanceof UserCreateNotifiable) {
            $event->user->sendUserCreatedNotification();
        }
    }
}
