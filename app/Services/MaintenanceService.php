<?php

namespace App\Services;

use App\Services\Contracts\MaintenanceContract;
use Illuminate\Support\Facades\Artisan;

/**
 * Class MaintenanceService
 * @package App\Services
 */
class MaintenanceService implements MaintenanceContract
{

    public function on()
    {
        Artisan::call('down --secret=roman');
    }

    public function off()
    {
        Artisan::call('up');
    }
}
