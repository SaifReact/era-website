<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailConfigRequest;
use App\Repositories\EmailConfigRepository;
use Illuminate\Http\Response;

/**
 * Class EmailConfigController
 * @package App\Http\Controllers\Api\Admin
 */
class EmailConfigController extends Controller
{
    /** @var EmailConfigRepository */
    private $emailConfigRepository;

    /**
     * EmailConfigController constructor.
     * @param EmailConfigRepository $emailConfigRepository
     */
    public function __construct(EmailConfigRepository $emailConfigRepository)
    {
        $this->emailConfigRepository = $emailConfigRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $emailConfig = $this->emailConfigRepository->first();

        return response()->json([
            'status' => true,
            'message' => 'Email config showed!',
            'data' => $emailConfig,
        ], Response::HTTP_OK);
    }

    /**
     * @param EmailConfigRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmailConfigRequest $request)
    {
        $emailConfig = $this->emailConfigRepository->first();

        if(!$emailConfig) {
            $emailConfig = $this->emailConfigRepository->create($request->post());
        }

        if($this->emailConfigRepository->update($emailConfig, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Email config updated!',
                'data' => $emailConfig->refresh(),
            ], Response::HTTP_OK);
        }
    }
}
