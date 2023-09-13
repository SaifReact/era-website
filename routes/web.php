<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Web\Admin\AuthController;
use \App\Http\Controllers\Web\Admin\VueAdminLayoutController;
use App\Http\Controllers\Web\Front\IndexController;
use \App\Http\Controllers\Web\Front\PageController;
use \App\Http\Controllers\Web\Front\PagePreviewController;
use \App\Http\Controllers\Web\Front\EventController;
use \App\Http\Controllers\Web\Front\EventPreviewController;
use \App\Http\Controllers\Web\Front\ContactController;
use \App\Http\Controllers\Web\Front\AboutController;
use \App\Http\Controllers\Web\Front\Components\BannerController as BannerComponentController;
use \App\Http\Controllers\Web\Front\Components\ResourceController as ResourceComponentController;
use \App\Http\Controllers\Web\Front\Components\MarketConcentrationController as MarketConcentrationComponentController;
use \App\Http\Controllers\Web\Front\Components\AboutUsController as AboutUsComponentController;
use \App\Http\Controllers\Web\Front\Components\ClientController as ClientComponentController;
use \App\Http\Controllers\Web\Front\Components\ProductController as ProductComponentController;
use \App\Http\Controllers\Web\Front\Components\PortfolioController as PortfolioComponentController;
use \App\Http\Controllers\Web\Front\Components\TestimonialController as TestimonialComponentController;
use \App\Http\Controllers\Web\Front\Components\EventController as EventComponentController;
use \App\Http\Controllers\Web\Front\Components\ManagementController as ManagementComponentController;
use App\Http\Controllers\Web\Front\DemoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Front
Route::get('/news-and-events', [EventController::class, 'index'])->name('event-list');
Route::get('/contacts', [ContactController::class, 'create'])->name('contact-new');
Route::get('/about', [AboutController::class, 'create'])->name('about-new');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact-store');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('event-show');
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('page-show');

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/components/banners', BannerComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.banners');
Route::get('/components/resource', ResourceComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.resource');
Route::get('/components/market-concentrations', MarketConcentrationComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.marketConcentrations');
Route::get('/components/about-us', AboutUsComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.aboutUs');
Route::get('/components/clients', ClientComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.clients');
Route::get('/components/products', ProductComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.products');
Route::get('/components/portfolios', PortfolioComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.portfolios');
Route::get('/components/testimonials', TestimonialComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.testimonials');
Route::get('/components/events', EventComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.events');
Route::get('/components/managements', ManagementComponentController::class)->middleware(['ajax', 'page-cache', 'etag'])->name('front.components.managements');

//Admin
Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login-store');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
    Route::get('/password-reset/{token}/{email}', [AuthController::class, 'passwordReset'])->middleware('guest')->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'passwordResetPost'])->middleware(['guest'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/demo/show', [DemoController::class, 'show'])->name('admin.demo-show');
    Route::get('/events/{event:slug}', [EventPreviewController::class, 'show'])->middleware('auth:sanctum')->name('admin.event-show');
    Route::get('/pages/{page:slug}', [PagePreviewController::class, 'show'])->middleware('auth:sanctum')->name('admin.page-show');
    Route::patch('/users/{user}', [AuthController::class, 'update'])->middleware('auth:sanctum')->name('user.update');
    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->middleware('auth:sanctum')->name('user.destroy');

    Route::get('/', [VueAdminLayoutController::class, 'index'])->name('admin.login');
});

/*Route::get('/', function () {
    return view('welcome');
})->name('login');*/