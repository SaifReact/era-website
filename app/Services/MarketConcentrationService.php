<?php


namespace App\Services;


use App\Repositories\MarketConcentrationRepository;

class MarketConcentrationService implements Contracts\MarketConcentrationContract
{
    /** @var MarketConcentrationRepository */
    private $marketConcentrationRepository;

    public function __construct(MarketConcentrationRepository $marketConcentrationRepository)
    {
        $this->marketConcentrationRepository = $marketConcentrationRepository;
    }

    public function getSortedMarketConcentrations() {
        return $this->marketConcentrationRepository->all()->sortBy('order');
    }
}
