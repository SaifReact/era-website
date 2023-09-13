<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\BannerService;
use App\Services\Contracts\BannerContract;
use App\Services\Contracts\IndexPageContract;
use App\Services\IndexPageService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /** @var BannerContract|BannerService */
    private $bannerService;

    public function __construct(BannerContract $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function __invoke()
    {
        return view('web.front.components.banners', [
            'banners' => $this->bannerService->getSortedBanners()
        ]);
    }
}
