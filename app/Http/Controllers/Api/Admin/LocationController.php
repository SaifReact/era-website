<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class LocationController extends Controller
{
    /** @var LocationRepository */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param Request $request
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->locationRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Location $location)
    {
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
    public function store(LocationRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Location created!',
            'data' => $this->locationRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Location $location
     * @param LocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Location $location, LocationRequest $request)
    {
        if($this->locationRepository->update($location, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Location updated!',
                'data' => $location->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Location $location)
    {
        if($this->locationRepository->delete($location)) {
            return response()->json([
                'status' => true,
                'message' => 'Location deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
