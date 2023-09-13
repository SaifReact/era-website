<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceInfoRequest;
use App\Models\ResourceInfo;
use App\Repositories\ResourceInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ResourceInfoController
 * @package App\Http\Controllers\Api\Admin
 */
class ResourceInfoController extends Controller
{
    /** @var ResourceInfoRepository */
    private $resourceInfoRepository;

    /**
     * ResourceInfoController constructor.
     * @param ResourceInfoRepository $resourceInfoRepository
     */
    public function __construct(ResourceInfoRepository $resourceInfoRepository)
    {
        $this->resourceInfoRepository = $resourceInfoRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Resource info listed!',
            'data' => $this->resourceInfoRepository->all(),
        ], Response::HTTP_OK);
    }

    /**
     * @param ResourceInfo $resourceInfo
     * @return JsonResponse
     */
    public function show(ResourceInfo $resourceInfo)
    {
        return response()->json([
            'status' => true,
            'message' => 'Resource info showed!',
            'data' => $resourceInfo,
        ], Response::HTTP_OK);
    }

    /**
     * @param ResourceInfoRequest $request
     * @return JsonResponse
     */
    public function store(ResourceInfoRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Resource info created!',
            'data' => $this->resourceInfoRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param ResourceInfo $resourceInfo
     * @param ResourceInfoRequest $request
     * @return JsonResponse
     */
    public function update(ResourceInfo $resourceInfo, ResourceInfoRequest $request)
    {
        if($this->resourceInfoRepository->update($resourceInfo, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Resource info updated!',
                'data' => $resourceInfo->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param ResourceInfo $resourceInfo
     * @return JsonResponse
     */
    public function destroy(ResourceInfo $resourceInfo)
    {
        if($this->resourceInfoRepository->delete($resourceInfo)) {
            return response()->json([
                'status' => true,
                'message' => 'Resource info deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
