<?php

namespace App\Repositories;

use App\Models\PortfolioCategory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PortfolioCategoryRepository
 * @package App\Repositories
 */
class PortfolioCategoryRepository extends Repository
{
    /**
     * PortfolioCategoryRepository constructor.
     * @param PortfolioCategory $portfolioCategory
     */
    public function __construct(PortfolioCategory $portfolioCategory)
    {
        parent::__construct($portfolioCategory);
    }
}
