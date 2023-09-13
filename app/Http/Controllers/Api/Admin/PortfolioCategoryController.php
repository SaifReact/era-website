<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioCategoryRequest;
use App\Models\PortfolioCategory;
use App\Repositories\PortfolioCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class PortfolioCategoryController
 * @package App\Http\Controllers\APi\Admin
 */
class PortfolioCategoryController extends Controller
{
    /** @var PortfolioCategoryRepository */
    private $portfolioCategoryRepository;

    /**
     * Class PortfolioCategoryController constructor.
     * @param PortfolioCategoryRepository $portfolioCategoryRepository
     */
    public function __construct(PortfolioCategoryRepository $portfolioCategoryRepository)
    {
        $this->portfolioCategoryRepository = $portfolioCategoryRepository;
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

        $query = $this->portfolioCategoryRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param PortfolioCategory $portfolioCategory
     * @return JsonResponse
     */
    public function show(PortfolioCategory $portfolioCategory)
    {
        return response()->json([
            'status' => true,
            'message' => 'Portfolio category showed!',
            'data' => $portfolioCategory,
        ], Response::HTTP_OK);
    }

    /**
     * @param PortfolioCategoryRequest $request
     * @return JsonResponse
     */
    public function store(PortfolioCategoryRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Portfolio category created!',
            'data' => $this->portfolioCategoryRepository->create($request->getParams()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param PortfolioCategory $portfolioCategory
     * @param PortfolioCategoryRequest $request
     * @return JsonResponse
     */
    public function update(PortfolioCategory $portfolioCategory, PortfolioCategoryRequest $request)
    {
        if ($this->portfolioCategoryRepository->update($portfolioCategory, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Portfolio category updated!',
                'data' => $portfolioCategory->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param PortfolioCategory $portfolioCategory
     * @return JsonResponse
     */
    public function destroy(PortfolioCategory $portfolioCategory)
    {
        if ($this->portfolioCategoryRepository->delete($portfolioCategory)) {
            return response()->json([
                'status' => true,
                'message' => 'Portfolio category deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }

    public function search(Request $request)
    {
        return response()->json([
            'data' => $this->portfolioCategoryRepository->all(),
        ]);
    }
}
