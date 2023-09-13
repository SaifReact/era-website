<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Silber\PageCache\Cache;

class PageCacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if((config('app.env') === 'production')) {
            $this->app[Cache::class]->setCachePath('page-cache'); // root path(public_html) for shared hosting.
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
