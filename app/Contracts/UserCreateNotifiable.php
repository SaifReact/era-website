<?php

namespace App\Contracts;

/**
 * Interface UserUpdateNotifiable
 * @package App\Contracts
 */
interface UserCreateNotifiable
{
    public function sendUserCreatedNotification();
}
