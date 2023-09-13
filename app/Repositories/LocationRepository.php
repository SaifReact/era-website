<?php

namespace App\Repositories;

use App\Models\Location;

/**
 * Class LocationRepository
 * @package App\Repositories
 */
class LocationRepository extends Repository
{
    /**
     * LocationRepository constructor.
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        parent::__construct($location);
    }
}
