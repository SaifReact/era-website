<?php


namespace App\Concerns;


use App\Models\EmailConfig;
use App\Notifications\UserCreated;
use App\Repositories\EmailConfigRepository;

trait CreateUser
{
    public function sendUserCreatedNotification()
    {
        $this->notify(new UserCreated($this));
    }
}
