<?php

namespace App\Concerns;

use App\Notifications\UserPasswordChanged;

trait ChangeUserPassword
{
    public function sendPasswordChangedNotification()
    {
        $this->notify(new UserPasswordChanged($this));
    }
}
