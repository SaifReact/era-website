<?php

namespace App\Contracts;

/**
 * Interface UserUpdateNotifiable
 * @package App\Contracts
 */
interface UserUpdateNotifiable
{
    public function sendUserUpdatedNotification();
}
