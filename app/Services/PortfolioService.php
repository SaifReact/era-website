<?php


namespace App\Services;


use App\Repositories\PortfolioRepository;

class PortfolioService implements Contracts\PortfolioContract
{
    /** @var PortfolioRepository */
    private $portfolioRepository;

    public function __construct(PortfolioRepository $portfolioRepository)
    {
        $this->portfolioRepository = $portfolioRepository;
    }

    public function getSortedPortfolios() {
        return $this->portfolioRepository->all()->sortBy('order');
    }
}
