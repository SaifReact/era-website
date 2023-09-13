<?php

namespace App\Services;

use App\Services\Contracts\CacheContract;
use Illuminate\Support\Facades\Artisan;

/**
 * Class CacheService
 * @package App\Services
 */
class CacheService implements CacheContract
{
    public function viewClear()
    {
        Artisan::call('view:clear');
        $this->pageCacheClear();
    }

    private function pageCacheClear()
    {
        Artisan::call('page-cache:clear');
    }

    public function viewCache()
    {
        Artisan::call('view:cache');
    }

    public function routeClear()
    {
        Artisan::call('route:clear');
    }

    public function routeCache()
    {
        Artisan::call('route:cache');
    }

    public function configClear()
    {
        Artisan::call('config:clear');
    }

    public function configCache()
    {
        Artisan::call('config:cache');
    }

    public function cacheClear()
    {
        Artisan::call('cache:clear');
    }
}
