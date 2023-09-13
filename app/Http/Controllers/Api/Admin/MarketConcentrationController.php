<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketConcentrationRequest;
use App\Models\MarketConcentration;
use App\Repositories\MarketConcentrationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class MarketConcentrationController
 * @package App\Http\Controllers\Api\Admin
 */
class MarketConcentrationController extends Controller
{
    /** @var MarketConcentrationRepository */
    private $marketConcentrationRepository;

    /**
     * MarketConcentrationController constructor.
     * @param MarketConcentrationRepository $marketConcentrationRepository
     */
    public function __construct(MarketConcentrationRepository $marketConcentrationRepository)
    {
        $this->marketConcentrationRepository = $marketConcentrationRepository;
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

        $query = $this->marketConcentrationRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param MarketConcentration $marketConcentration
     * @return JsonResponse
     */
    public function show(MarketConcentration $marketConcentration)
    {
        return response()->json([
            'status' => true,
            'message' => 'Market concentration showed!',
            'data' => $marketConcentration,
        ], Response::HTTP_OK);
    }

    /**
     * @param MarketConcentrationRequest $request
     * @return JsonResponse
     */
    public function store(MarketConcentrationRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Market concentration created!',
            'data' => $this->marketConcentrationRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param MarketConcentration $marketConcentration
     * @param MarketConcentrationRequest $marketConcentrationRequest
     * @return JsonResponse
     */
    public function update(MarketConcentration $marketConcentration,
                           MarketConcentrationRequest $marketConcentrationRequest)
    {
        if($this->marketConcentrationRepository->update($marketConcentration, $marketConcentrationRequest->post()))
        {
            return response()->json([
                'status' => true,
                'message' => 'Market concentration updated!',
                'data' => $marketConcentration->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param MarketConcentration $marketConcentration
     * @return JsonResponse
     */
    public function destroy(MarketConcentration $marketConcentration)
    {
        if($this->marketConcentrationRepository->delete($marketConcentration)) {
            return response()->json([
                'status' => true,
                'message' => 'Market concentration deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
