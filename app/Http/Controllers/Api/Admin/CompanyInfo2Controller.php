<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInfoRequest;
use App\Models\CompanyInfo;
use App\Repositories\CompanyInfoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CompanyInfo2Controller
 * @package App\Http\Controllers\Api\Admin
 */
class CompanyInfo2Controller extends Controller
{
    /** @var CompanyInfoRepository */
    private $companyInfoRepository;

    /**
     * CompanyInfo2Controller constructor.
     * @param CompanyInfoRepository $companyInfoRepository
     */
    public function __construct(CompanyInfoRepository $companyInfoRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
    }

    /**
     * @return JsonResponse
     */
    public function show() {
        $companyInfo = $this->companyInfoRepository->first();

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
    public function update(CompanyInfoRequest $request) {
        $companyInfo = $this->companyInfoRepository->first();

        if($this->companyInfoRepository->update($companyInfo, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Company info updated!',
                'data' => $companyInfo->refresh(),
            ], Response::HTTP_OK);
        }
    }
}
