<?php


namespace App\Repositories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PortfolioRepository
 * @package App\Repositories
 */
class PortfolioRepository extends Repository
{
    /**
     * PortfolioRepository constructor.
     * @param Portfolio $portfolio
     */
    public function __construct(Portfolio $portfolio)
    {
        parent::__construct($portfolio);
    }
}
