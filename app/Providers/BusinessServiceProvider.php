<?php

namespace App\Providers;

use App\Services\AboutUsService;
use App\Services\BannerService;
use App\Services\CacheService;
use App\Services\ClientCategoryService;
use App\Services\ClientService;
use App\Services\CompanyInfoService;
use App\Services\ContactService;
use App\Services\Contracts\AboutUsContract;
use App\Services\Contracts\AuthContract;
use App\Services\Contracts\BannerContract;
use App\Services\Contracts\CacheContract;
use App\Services\Contracts\ClientCategoryContract;
use App\Services\Contracts\ClientContract;
use App\Services\Contracts\CompanyInfoContract;
use App\Services\Contracts\ContactContract;
use App\Services\Contracts\EventContract;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\LocationContract;
use App\Services\Contracts\MaintenanceContract;
use App\Services\Contracts\ManagementContract;
use App\Services\Contracts\MarketConcentrationContract;
use App\Services\Contracts\MenuItemContract;
use App\Services\Contracts\PortfolioCategoryContract;
use App\Services\Contracts\PortfolioContract;
use App\Services\Contracts\ProductContract;
use App\Services\Contracts\ResourceInfoContract;
use App\Services\Contracts\TestimonialContract;
use App\Services\EventService;
use App\Services\IndexPageService;
use App\Services\LocationService;
use App\Services\MaintenanceService;
use App\Services\ManagementService;
use App\Services\MarketConcentrationService;
use App\Services\MenuItemService;
use App\Services\PortfolioCategoryService;
use App\Services\PortfolioService;
use App\Services\ProductService;
use App\Services\ResourceInfoService;
use App\Services\TestimonialService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider
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
        $this->app->singleton(IndexPageContract::class, IndexPageService::class);
        $this->app->singleton(CompanyInfoContract::class, CompanyInfoService::class);
        $this->app->singleton(ContactContract::class, ContactService::class);
        $this->app->singleton(LocationContract::class, LocationService::class);
        $this->app->singleton(PortfolioCategoryContract::class, PortfolioCategoryService::class);
        $this->app->singleton(BannerContract::class, BannerService::class);
        $this->app->singleton(ResourceInfoContract::class, ResourceInfoService::class);
        $this->app->singleton(MarketConcentrationContract::class, MarketConcentrationService::class);
        $this->app->singleton(AboutUsContract::class, AboutUsService::class);
        $this->app->singleton(ClientContract::class, ClientService::class);
        $this->app->singleton(ClientCategoryContract::class, ClientCategoryService::class);
        $this->app->singleton(ProductContract::class, ProductService::class);
        $this->app->singleton(PortfolioContract::class, PortfolioService::class);
        $this->app->singleton(TestimonialContract::class, TestimonialService::class);
        $this->app->singleton(EventContract::class, EventService::class);
        $this->app->singleton(ManagementContract::class, ManagementService::class);
        $this->app->singleton(AuthContract::class, UserService::class);
        $this->app->singleton(MenuItemContract::class, MenuItemService::class);
        $this->app->singleton(CacheContract::class, CacheService::class);
        $this->app->singleton(MaintenanceContract::class, MaintenanceService::class);
    }
}
