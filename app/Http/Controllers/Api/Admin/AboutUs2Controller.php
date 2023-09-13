<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use App\Repositories\AboutUsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class AboutUs2Controller
 * @package App\Http\Controllers\Api\Admin
 */
class AboutUs2Controller extends Controller
{
    /** @var AboutUsRepository */
    private $aboutUsRepository;

    /**
     * AboutUs2Controller constructor.
     * @param AboutUsRepository $aboutUsRepository
     */
    public function __construct(AboutUsRepository $aboutUsRepository)
    {
        $this->aboutUsRepository = $aboutUsRepository;
    }

    /**
     * @return JsonResponse
     */
    public function show()
    {
        $aboutUs = $this->aboutUsRepository->first();

        return response()->json([
            'status' => true,
            'message' => 'About us showed!',
            'data' => $aboutUs,
        ], Response::HTTP_OK);
    }

    /**
     * @param AboutUsRequest $request
     * @return JsonResponse
     */
    public function update(AboutUsRequest $request)
    {
        $aboutUs = $this->aboutUsRepository->first();

        if($this->aboutUsRepository->update($aboutUs, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'About us updated!',
                'data' => $aboutUs->refresh(),
            ], Response::HTTP_OK);
        }
    }
}
