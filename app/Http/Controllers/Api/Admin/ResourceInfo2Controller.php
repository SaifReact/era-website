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
 * Class ResourceInfo2Controller
 * @package App\Http\Controllers\Api\Admin
 */
class ResourceInfo2Controller extends Controller
{
    /** @var ResourceInfoRepository */
    private $resourceInfoRepository;

    /**
     * ResourceInfo2Controller constructor.
     * @param ResourceInfoRepository $resourceInfoRepository
     */
    public function __construct(ResourceInfoRepository $resourceInfoRepository)
    {
        $this->resourceInfoRepository = $resourceInfoRepository;
    }

    /**
     * @return JsonResponse
     */
    public function show()
    {
        $resourceInfo = $this->resourceInfoRepository->first();

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
    public function update(ResourceInfoRequest $request)
    {
        $resourceInfo = $this->resourceInfoRepository->first();

        if($this->resourceInfoRepository->update($resourceInfo, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Resource info updated!',
                'data' => $resourceInfo->refresh(),
            ], Response::HTTP_OK);
        }
    }
}
