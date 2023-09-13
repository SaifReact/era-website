<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementRequest;
use App\Models\Management;
use App\Repositories\ManagementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class ManagementController
 * @package App\Http\Controllers\Api\Admin
 */
class ManagementController extends Controller
{
    /** @var ManagementRepository */
    private $managementRepository;

    /**
     * ManagementController constructor.
     * @param ManagementRepository $managementRepository
     */
    public function __construct(ManagementRepository $managementRepository)
    {
        $this->managementRepository = $managementRepository;
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

        $query = $this->managementRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Management $management
     * @return JsonResponse
     */
    public function show(Management $management)
    {
        return response()->json([
            'status' => true,
            'message' => 'Management showed!',
            'data' => $management,
        ], Response::HTTP_OK);
    }

    /**
     * @param ManagementRequest $request
     * @return JsonResponse
     */
    public function store(ManagementRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Management created!',
            'data' => $this->managementRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Management $management
     * @param ManagementRequest $request
     * @return JsonResponse
     */
    public function update(Management $management, ManagementRequest $request)
    {
        if($this->managementRepository->update($management, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Management updated!',
                'data' => $management->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Management $management
     * @return JsonResponse
     */
    public function destroy(Management $management)
    {
        if($this->managementRepository->delete($management)) {
            return response()->json([
                'status' => true,
                'message' => 'Management deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
