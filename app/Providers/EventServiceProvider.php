<?php

namespace App\Providers;

use App\Events\UserCreated;
use App\Events\UserPasswordChanged;
use App\Events\UserUpdated;
use App\Listeners\SendUserCreateNotification;
use App\Listeners\SendUserPasswordChangeNotification;
use App\Listeners\SendUserUpdateNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            SendUserCreateNotification::class,
        ],
        UserUpdated::class => [
            SendUserUpdateNotification::class,
        ],
        UserPasswordChanged::class => [
            SendUserPasswordChangeNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
