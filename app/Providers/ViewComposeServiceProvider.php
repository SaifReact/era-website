<?php

namespace App\Providers;

use App\View\Composers\BreadCrumbComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\HeaderMenuComposer;
use App\View\Composers\FooterMenuComposer;
use App\View\Composers\CompanyInfoComposer;
use App\View\Composers\ContactComposer;
use App\View\Composers\LocationComposer;

/**
 * Class ViewServiceProvider
 * @package App\Providers
 */
class ViewComposeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('web.front.partials.header', CompanyInfoComposer::class);
        View::composer('web.front.partials.header', ContactComposer::class);
        View::composer('web.front.partials.header', LocationComposer::class);
        View::composer('web.front.partials.footer', CompanyInfoComposer::class);
        View::composer('web.front.partials.footer', ContactComposer::class);
        View::composer('web.front.partials.footer', LocationComposer::class);
        View::composer('web.front.partials.menu', HeaderMenuComposer::class);
        View::composer('web.front.partials.breadcrumb', BreadCrumbComposer::class);
        View::composer('web.front.partials.footer', FooterMenuComposer::class);
    }
}
