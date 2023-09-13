<?php


namespace App\Concerns;


use App\Models\EmailConfig;
use App\Notifications\UserUpdated;
use App\Repositories\EmailConfigRepository;

trait UpdateUser
{
    public function sendUserUpdatedNotification()
    {
        $this->notify(new UserUpdated($this));
    }
}
