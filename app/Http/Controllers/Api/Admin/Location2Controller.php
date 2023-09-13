<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Repositories\LocationRepository;
use Illuminate\Http\Response;

/**
 * Class Location2Controller
 * @package App\Http\Controllers\Api\Admin
 */
class Location2Controller extends Controller
{
    /** @var LocationRepository */
    private $locationRepository;

    /**
     * Location2Controller constructor.
     * @param LocationRepository $locationRepository
     */
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $location = $this->locationRepository->first();

        return response()->json([
            'status' => true,
            'message' => 'Location showed!',
            'data' => $location,
        ], Response::HTTP_OK);
    }

    /**
     * @param LocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LocationRequest $request)
    {
        $location = $this->locationRepository->first();

        if(!$location) {
            $location = $this->locationRepository->create($request->post());
        }

        if($this->locationRepository->update($location, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Location updated!',
                'data' => $location->refresh(),
            ], Response::HTTP_OK);
        }
    }
}
