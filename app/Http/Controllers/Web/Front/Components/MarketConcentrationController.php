<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\MarketConcentrationContract;
use App\Services\IndexPageService;
use App\Services\MarketConcentrationService;
use Illuminate\Http\Request;

class MarketConcentrationController extends Controller
{
    /** @var MarketConcentrationContract|MarketConcentrationService */
    private $marketConcentrationService;

    public function __construct(MarketConcentrationContract $marketConcentrationService)
    {
        $this->marketConcentrationService = $marketConcentrationService;
    }

    public function __invoke()
    {
        return view('web.front.components.market-concentration', [
            'marketConcentrations' => $this->marketConcentrationService->getSortedMarketConcentrations()
        ]);
    }
}
