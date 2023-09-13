<?php

namespace App\Services\Contracts;

interface MaintenanceContract
{
    public function on();
    public function off();
}
