<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class TestimonialController
 * @package App\Http\Controllers\Api\Admin
 */
class TestimonialController extends Controller
{
    /** @var TestimonialRepository */
    private $testimonialRepository;

    /**
     * TestimonialController constructor.
     * @param TestimonialRepository $testimonialRepository
     */
    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
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

        $query = $this->testimonialRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function show(Testimonial $testimonial)
    {
        return response()->json([
            'status' => true,
            'message' => 'Testimonial showed!',
            'data' => $testimonial,
        ], Response::HTTP_OK);
    }

    /**
     * @param TestimonialRequest $request
     * @return JsonResponse
     */
    public function store(TestimonialRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Testimonial created!',
            'data' => $this->testimonialRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Testimonial $testimonial
     * @param TestimonialRequest $request
     * @return JsonResponse
     */
    public function update(Testimonial $testimonial, TestimonialRequest $request)
    {
        if($this->testimonialRepository->update($testimonial, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Testimonial updated!',
                'data' => $testimonial->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        if($this->testimonialRepository->delete($testimonial)) {
            return response()->json([
                'status' => true,
                'message' => 'Testimonial deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
