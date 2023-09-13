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
 * Class AboutUsController
 * @package App\Http\Controllers\Api\Admin
 */
class AboutUsController extends Controller
{
    /** @var AboutUsRepository */
    private $aboutUsRepository;

    /**
     * AboutUsController constructor.
     * @param AboutUsRepository $aboutUsRepository
     */
    public function __construct(AboutUsRepository $aboutUsRepository)
    {
        $this->aboutUsRepository = $aboutUsRepository;
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

        $query = $this->aboutUsRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param AboutUs $aboutUs
     * @return JsonResponse
     */
    public function show(AboutUs $aboutUs)
    {
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
    public function store(AboutUsRequest $request)
    {
        return response()->json([
                'status' => true,
                'message' => 'About us created!',
                'data' => $this->aboutUsRepository->create($request->post())
            ], Response::HTTP_CREATED);
    }

    /**
     * @param AboutUs $aboutUs
     * @param AboutUsRequest $request
     * @return JsonResponse
     */
    public function update(AboutUs $aboutUs, AboutUsRequest $request)
    {
        if($this->aboutUsRepository->update($aboutUs, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'About us updated!',
                'data' => $aboutUs->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param AboutUs $aboutUs
     * @return JsonResponse
     */
    public function destroy(AboutUs $aboutUs)
    {
        if($this->aboutUsRepository->delete($aboutUs)) {
            return response()->json([
                'status' => true,
                'message' => 'About us deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
