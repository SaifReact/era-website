<?php

use App\Http\Controllers\Api\Admin\ClientCategoryController;
use App\Http\Controllers\Api\Admin\MaintenanceController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\Admin\CompanyInfoController;
use \App\Http\Controllers\Api\Admin\CompanyInfo2Controller;
use \App\Http\Controllers\Api\Admin\BannerController;
use App\Http\Controllers\Api\Admin\ResourceInfoController;
use App\Http\Controllers\Api\Admin\ResourceInfo2Controller;
use App\Http\Controllers\Api\Admin\MarketConcentrationController;
use App\Http\Controllers\Api\Admin\AboutUsController;
use App\Http\Controllers\Api\Admin\AboutUs2Controller;
use App\Http\Controllers\Api\Admin\ClientController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\PortfolioCategoryController;
use App\Http\Controllers\Api\Admin\PortfolioController;
use App\Http\Controllers\Api\Admin\TestimonialController;
use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\ManagementController;
use App\Http\Controllers\Api\Admin\PageController;
use App\Http\Controllers\Api\Admin\MenuController;
use App\Http\Controllers\Api\Admin\MenuItemController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\UserProfileController;
use App\Http\Controllers\Api\Admin\CacheController;
use App\Http\Controllers\Api\Admin\EmailConfigController;
use App\Http\Controllers\Api\Admin\ContactController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\Location2Controller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'admin'], function () {
    /** Hidden from frontend admin users */
    Route::get('/cache/view-cache', [CacheController::class, 'viewCache']);
    Route::get('/cache/route-clear', [CacheController::class, 'routeClear']);
    Route::get('/cache/route-cache', [CacheController::class, 'routeCache']);
    Route::get('/cache/config-clear', [CacheController::class, 'configClear']);
    Route::get('/cache/config-cache', [CacheController::class, 'configCache']);
    Route::get('/cache/cache-clear', [CacheController::class, 'cacheClear']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        /*Route::get('/company-infos', [CompanyInfosController::class, 'index']);
        Route::get('/company-infos/{companyInfo}', [CompanyInfosController::class, 'show']);
        Route::post('/company-infos', [CompanyInfosController::class, 'store']);
        Route::patch('/company-infos/{companyInfo}', [CompanyInfosController::class, 'update']);
        Route::delete('/company-infos/{companyInfo}', [CompanyInfosController::class, 'destroy']);*/

        Route::get('/company-infos', [CompanyInfo2Controller::class, 'show']);
        Route::patch('/company-infos', [CompanyInfo2Controller::class, 'update']);

        Route::get('/email-configs', [EmailConfigController::class, 'show']);
        Route::patch('/email-configs', [EmailConfigController::class, 'update']);

        Route::get('/banners', [BannerController::class, 'index']);
        Route::get('/banners/{banner}', [BannerController::class, 'show']);
        Route::post('/banners', [BannerController::class, 'store']);
        Route::patch('/banners/{banner}', [BannerController::class, 'update']);
        Route::delete('/banners/{banner}', [BannerController::class, 'destroy']);

        /*Route::get('/resource-infos', [ResourceInfosController::class, 'index']);
        Route::get('/resource-infos/{resourceInfo}', [ResourceInfosController::class, 'show']);
        Route::post('/resource-infos', [ResourceInfosController::class, 'store']);
        Route::patch('/resource-infos/{resourceInfo}', [ResourceInfosController::class, 'update']);
        Route::delete('/resource-infos/{resourceInfo}', [ResourceInfosController::class, 'destroy']);*/

        Route::get('/resource-infos', [ResourceInfo2Controller::class, 'show']);
        Route::patch('/resource-infos', [ResourceInfo2Controller::class, 'update']);

        Route::get('/market-concentrations', [MarketConcentrationController::class, 'index']);
        Route::get('/market-concentrations/{marketConcentration}',
            [MarketConcentrationController::class, 'show']);
        Route::post('/market-concentrations', [MarketConcentrationController::class, 'store']);
        Route::patch('/market-concentrations/{marketConcentration}',
            [MarketConcentrationController::class, 'update']);
        Route::delete('/market-concentrations/{marketConcentration}',
            [MarketConcentrationController::class, 'destroy']);

        /*Route::get('/about-us', [AboutUsController::class, 'index']);
        Route::get('/about-us/{aboutUs}', [AboutUsController::class, 'show']);
        Route::post('/about-us', [AboutUsController::class, 'store']);
        Route::patch('/about-us/{aboutUs}', [AboutUsController::class, 'update']);
        Route::delete('/about-us/{aboutUs}', [AboutUsController::class, 'destroy']);*/

        Route::get('/about-us', [AboutUs2Controller::class, 'show']);
        Route::patch('/about-us', [AboutUs2Controller::class, 'update']);

        Route::get('/client-categories', [ClientCategoryController::class, 'index']);
        Route::get('/search-client-categories', [ClientCategoryController::class, 'search']);
        Route::get('/client-categories/{clientCategory}', [ClientCategoryController::class, 'show']);
        Route::post('/client-categories', [ClientCategoryController::class, 'store']);
        Route::patch('/client-categories/{clientCategory}', [ClientCategoryController::class, 'update']);
        Route::delete('/client-categories/{clientCategory}', [ClientCategoryController::class, 'destroy']);

        Route::get('/clients', [ClientController::class, 'index']);
        Route::get('/clients/{client}', [ClientController::class, 'show']);
        Route::post('/clients', [ClientController::class, 'store']);
        Route::patch('/clients/{client}', [ClientController::class, 'update']);
        Route::delete('/clients/{client}', [ClientController::class, 'destroy']);

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{product}', [ProductController::class, 'show']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/portfolio-categories', [PortfolioCategoryController::class, 'index']);
        Route::get('/search-portfolio-categories', [PortfolioCategoryController::class, 'search']);
        Route::get('/portfolio-categories/{portfolioCategory}', [PortfolioCategoryController::class, 'show']);
        Route::post('/portfolio-categories', [PortfolioCategoryController::class, 'store']);
        Route::patch('/portfolio-categories/{portfolioCategory}', [PortfolioCategoryController::class, 'update']);
        Route::delete('/portfolio-categories/{portfolioCategory}', [PortfolioCategoryController::class, 'destroy']);

        Route::get('/portfolios', [PortfolioController::class, 'index']);
        Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show']);
        Route::post('/portfolios', [PortfolioController::class, 'store']);
        Route::patch('/portfolios/{portfolio}', [PortfolioController::class, 'update']);
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy']);

        Route::get('/testimonials', [TestimonialController::class, 'index']);
        Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show']);
        Route::post('/testimonials', [TestimonialController::class, 'store']);
        Route::patch('/testimonials/{testimonial}', [TestimonialController::class, 'update']);
        Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{event}', [EventController::class, 'show']);
        Route::post('/events', [EventController::class, 'store']);
        Route::patch('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);

        Route::get('/managements', [ManagementController::class, 'index']);
        Route::get('/managements/{management}', [ManagementController::class, 'show']);
        Route::post('/managements', [ManagementController::class, 'store']);
        Route::patch('/managements/{management}', [ManagementController::class, 'update']);
        Route::delete('/managements/{management}', [ManagementController::class, 'destroy']);

        Route::get('/contacts', [ContactController::class, 'index']);
        Route::get('/contacts/{contact}', [ContactController::class, 'show']);
        Route::post('/contacts', [ContactController::class, 'store']);
        Route::patch('/contacts/{contact}', [ContactController::class, 'update']);
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);

        /*Route::get('/locations', [LocationController::class, 'index']);
        Route::get('/locations/{location}', [LocationController::class, 'show']);
        Route::post('/locations', [LocationController::class, 'store']);
        Route::patch('/locations/{location}', [LocationController::class, 'update']);
        Route::delete('/locations/{location}', [LocationController::class, 'destroy']);*/

        Route::get('/locations', [Location2Controller::class, 'show']);
        Route::patch('/locations', [Location2Controller::class, 'update']);

        Route::get('/pages', [PageController::class, 'index']);
        Route::get('/pages/{page}', [PageController::class, 'show']);
        Route::post('/pages', [PageController::class, 'store']);
        Route::patch('/pages/{page}', [PageController::class, 'update']);
        Route::delete('/pages/{page}', [PageController::class, 'destroy']);

        Route::get('/menus', [MenuController::class, 'index']);
        Route::get('/menus/{menu}', [MenuController::class, 'show']);
        Route::post('/menus', [MenuController::class, 'store']);
        Route::patch('/menus/{menu}', [MenuController::class, 'update']);
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy']);

        Route::get('/menu-items', [MenuItemController::class, 'index']);
        Route::get('/menu-items/{menuItem}', [MenuItemController::class, 'show']);
        Route::post('/menu-items', [MenuItemController::class, 'store']);
        Route::post('/menu-items/balk', [MenuItemController::class, 'balkStore']);
        Route::patch('/menu-items/{menuItem}', [MenuItemController::class, 'update']);
        Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/user-info', [UserController::class, 'userInfo']);
        Route::get('/users/{user}', [UserController::class, 'show']);

        Route::get('/user-profiles/show', [UserProfileController::class, 'show']);
        Route::PATCH('/user-profiles/update', [UserProfileController::class, 'update']);

        Route::post('/register', [UserController::class, 'register']);

        Route::delete('/cache/view-clear', [CacheController::class, 'viewClear']);

        Route::get('/maintenance/on', [MaintenanceController::class, 'on']);
        Route::get('/maintenance/off', [MaintenanceController::class, 'off']);
        Route::get('/maintenance/show', [MaintenanceController::class, 'show']);
    });
});


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
