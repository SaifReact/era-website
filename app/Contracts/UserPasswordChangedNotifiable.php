<?php


namespace App\Contracts;


interface UserPasswordChangedNotifiable
{
    public function sendPasswordChangedNotification();
}
