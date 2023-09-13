<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\MaintenanceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MaintenanceController extends Controller
{
    /** @var MaintenanceContract */
    private $maintenanceService;

    /**
     * MaintenanceController constructor.
     * @param MaintenanceContract $maintenanceService
     */
    public function __construct(MaintenanceContract $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function on()
    {
        try {
            $this->maintenanceService->on();
            return response()->json([
                'status' => true,
                'message' => 'Application is in maintenance mode!',
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function off()
    {
        try {
            $this->maintenanceService->off();
            return response()->json([
                'status' => true,
                'message' => 'Application is live!',
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

    public function show()
    {
        $maintenanceStatus = false;

        if (file_exists(storage_path().'/framework/maintenance.php')) {
            $maintenanceStatus = true;
        }

        try {
            return response()->json([
                'status' => true,
                'message' => 'Application is live!',
                'data' => ['maintenance_status' => $maintenanceStatus],
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
