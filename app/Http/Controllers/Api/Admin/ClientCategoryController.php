<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientCategoryRequest;
use App\Models\ClientCategory;
use App\Repositories\ClientCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class ClientCategoryController
 * @package App\Http\Controllers\Api\Admin
 */
class ClientCategoryController extends Controller
{
    /** @var ClientCategoryRepository */
    private $clientCategoryRepository;

    /**
     * ClientCategoryController constructor.
     * @param ClientCategoryRepository $clientCategoryRepository
     */
    public function __construct(ClientCategoryRepository $clientCategoryRepository)
    {
        $this->clientCategoryRepository = $clientCategoryRepository;
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

        $query = $this->clientCategoryRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param ClientCategory $clientCategory
     * @return JsonResponse
     */
    public function show(ClientCategory $clientCategory)
    {
        return response()->json([
            'status' => true,
            'message' => 'Client category showed!',
            'data' => $clientCategory,
        ], Response::HTTP_OK);
    }

    /**
     * @param ClientCategoryRequest $request
     * @return JsonResponse
     */
    public function store(ClientCategoryRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Client category created!',
            'data' => $this->clientCategoryRepository->create($request->getParams()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param ClientCategory $clientCategory
     * @param ClientCategoryRequest $request
     * @return JsonResponse
     */
    public function update(ClientCategory $clientCategory, ClientCategoryRequest $request)
    {
        if ($this->clientCategoryRepository->update($clientCategory, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Client category updated!',
                'data' => $clientCategory->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param ClientCategory $clientCategory
     * @return JsonResponse
     */
    public function destroy(ClientCategory $clientCategory)
    {
        if ($this->clientCategoryRepository->delete($clientCategory)) {
            return response()->json([
                'status' => true,
                'message' => 'Client category deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function search(Request $request)
    {
        return response()->json([
            'data' => $this->clientCategoryRepository->all(),
        ]);
    }
}
