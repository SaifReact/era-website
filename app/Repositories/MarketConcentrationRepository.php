<?php


namespace App\Repositories;


use App\Models\MarketConcentration;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MarketConcentrationRepository
 * @package App\Repositories
 */
class MarketConcentrationRepository extends Repository
{
    /**
     * MarketConcentrationRepository constructor.
     * @param MarketConcentration $marketConcentration
     */
    public function __construct(MarketConcentration $marketConcentration)
    {
        parent::__construct($marketConcentration);
    }
}
