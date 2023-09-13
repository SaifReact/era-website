<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\CacheContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CacheController
 * @package App\Http\Controllers\Api\Admin
 */
class CacheController extends Controller
{
    /** @var CacheContract */
    private $cacheService;

    public function __construct(CacheContract $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function viewClear()
    {
        try {
            $this->cacheService->viewClear();
            return response()->json([
                'status' => true,
                'message' => 'Application view cache cleared!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function viewCache()
    {
        try {
            $this->cacheService->viewCache();
            return response()->json([
                'status' => true,
                'message' => 'Application view cached!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function routeClear()
    {
        try {
            $this->cacheService->routeClear();
            return response()->json([
                'status' => true,
                'message' => 'Application route cache cleared!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function routeCache()
    {
        try {
            $this->cacheService->routeCache();
            return response()->json([
                'status' => true,
                'message' => 'Application route cached!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function cacheClear()
    {
        try {
            $this->cacheService->cacheClear();
            return response()->json([
                'status' => true,
                'message' => 'Application cache cleared!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function configClear()
    {
        try {
            $this->cacheService->configClear();
            return response()->json([
                'status' => true,
                'message' => 'Application config cache cleared!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function configCache()
    {
        try {
            $this->cacheService->configCache();
            return response()->json([
                'status' => true,
                'message' => 'Application config cached!',
                'data' => null,
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
