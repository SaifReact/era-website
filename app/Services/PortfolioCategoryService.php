<?php


namespace App\Services;


use App\Repositories\PortfolioCategoryRepository;
use App\Repositories\PortfolioRepository;

class PortfolioCategoryService implements Contracts\PortfolioCategoryContract
{
    /** @var PortfolioCategoryRepository */
    private $portfolioCategoryRepository;

    public function __construct(PortfolioCategoryRepository $portfolioCategoryRepository)
    {
        $this->portfolioCategoryRepository = $portfolioCategoryRepository;
    }

    public function getSortedPortfolioCategories() {
        return $this->portfolioCategoryRepository->all()->sortBy('order');
    }
}
