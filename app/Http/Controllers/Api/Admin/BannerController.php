<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\BannerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Services\BannerService;
use App\Services\Contracts\BannerContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\Admin
 */
class BannerController extends Controller
{
    /** @var BannerRepository */
    private $bannerRepository;

    /** @var BannerService */
    private $bannerService;

    /**
     * BannerController constructor.
     * @param BannerRepository $bannerRepository
     * @param BannerContract $bannerService
     */
    public function __construct(BannerRepository $bannerRepository, BannerContract $bannerService)
    {
        $this->bannerRepository = $bannerRepository;
        $this->bannerService = $bannerService;
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

        $query = $this->bannerRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Banner $banner
     * @return JsonResponse
     */
    public function show(Banner $banner)
    {
        return response()->json([
            'status' => true,
            'message' => 'Banner showed!',
            'data' => $banner,
        ], Response::HTTP_OK);
    }

    /**
     * @param BannerRequest $request
     * @return JsonResponse
     * @throws BannerException
     */
    public function store(BannerRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Banner created!',
            'data' => $this->bannerService->add($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Banner $banner
     * @param BannerRequest $request
     * @return JsonResponse
     */
    public function update(Banner $banner, BannerRequest $request)
    {
        if($this->bannerRepository->update($banner, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Banner updated!',
                'data' => $banner->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Banner $banner
     * @return JsonResponse
     */
    public function destroy(Banner $banner)
    {
        if($this->bannerRepository->delete($banner)) {
            return response()->json([
                'status' => true,
                'message' => 'Banner deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
