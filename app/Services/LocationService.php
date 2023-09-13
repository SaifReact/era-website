<?php


namespace App\Services;


use App\Repositories\LocationRepository;

class LocationService implements Contracts\LocationContract
{
    /** @var LocationRepository */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getLocation() {
        return $this->locationRepository->first();
    }
}
