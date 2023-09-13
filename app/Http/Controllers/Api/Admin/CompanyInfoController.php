<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInfoRequest;
use App\Models\CompanyInfo;
use App\Repositories\CompanyInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CompanyInfoController
 * @package App\Http\Controllers\Api\Admin
 */
class CompanyInfoController extends Controller
{
    /** @var CompanyInfoRepository */
    private $companyInfoRepository;

    /**
     * CompanyInfoController constructor.
     * @param CompanyInfoRepository $companyInfoRepository
     */
    public function __construct(CompanyInfoRepository $companyInfoRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index() {
        return response()->json([
            'status' => true,
            'message' => 'Company info listed!',
            'data' => $this->companyInfoRepository->all()
        ], Response::HTTP_OK);
    }

    /**
     * @param CompanyInfo $companyInfo
     * @return JsonResponse
     */
    public function show(CompanyInfo $companyInfo) {
        return response()->json([
            'status' => true,
            'message' => 'Company info showed!',
            'data' => $companyInfo,
        ], Response::HTTP_OK);
    }

    /**
     * @param CompanyInfoRequest $request
     * @return JsonResponse
     */
    public function store(CompanyInfoRequest $request) {
        return response()->json([
            'status' => true,
            'message' => 'Company info created!',
            'data' => $this->companyInfoRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param CompanyInfo $companyInfo
     * @param CompanyInfoRequest $request
     * @return JsonResponse
     */
    public function update(CompanyInfo $companyInfo, CompanyInfoRequest $request) {
        if($this->companyInfoRepository->update($companyInfo, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Company info updated!',
                'data' => $companyInfo->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param CompanyInfo $companyInfo
     * @return JsonResponse
     */
    public function destroy(CompanyInfo $companyInfo) {
        if($this->companyInfoRepository->delete($companyInfo)) {
            return response()->json([
                'status' => true,
                'message' => 'Company info deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
