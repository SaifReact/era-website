<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\PortfolioContract;
use App\Services\IndexPageService;
use App\Services\PortfolioCategoryService;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /** @var PortfolioCategoryService */
    private $portfolioCategoryService;

    /** @var PortfolioContract|PortfolioService */
    private $portfolioService;

    public function __construct(PortfolioCategoryService $portfolioCategoryService, PortfolioContract $portfolioService)
    {
        $this->portfolioCategoryService = $portfolioCategoryService;
        $this->portfolioService = $portfolioService;
    }

    public function __invoke()
    {
        return view('web.front.components.portfolios', [
            'portfolios' => $this->portfolioService->getSortedPortfolios(),
            'portfolioCategories' => $this->portfolioCategoryService->getSortedPortfolioCategories(),
        ]);
    }
}
