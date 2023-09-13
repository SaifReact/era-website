<?php

namespace App\View\Composers;

use App\Repositories\LocationRepository;
use Illuminate\View\View;

/**
 * Class LocationComposer
 * @package App\View\Composers
 */
class LocationComposer
{
    /** @var LocationRepository */
    private $locationRepository;

    /**
     * LocationComposer constructor.
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function compose(View $view)
    {
        $view->with('location', $this->locationRepository->first());
    }
}
