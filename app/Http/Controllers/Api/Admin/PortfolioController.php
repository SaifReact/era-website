<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use App\Repositories\PortfolioRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class PortfolioController
 * @package App\Http\Controllers\Api\Admin
 */
class PortfolioController extends Controller
{
    /** @var PortfolioRepository */
    private $portfolioRepository;

    /**
     * PortfolioController constructor.
     * @param PortfolioRepository $portfolioRepository
     */
    public function __construct(PortfolioRepository $portfolioRepository)
    {
        $this->portfolioRepository = $portfolioRepository;
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

        $query = $this->portfolioRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Portfolio $portfolio
     * @return JsonResponse
     */
    public function show(Portfolio $portfolio)
    {
        return response()->json([
            'status' => true,
            'message' => 'Portfolio showed!',
            'data' => $portfolio,
        ], Response::HTTP_OK);
    }

    /**
     * @param PortfolioRequest $portfolioRequest
     * @return JsonResponse
     */
    public function store(PortfolioRequest $portfolioRequest)
    {
        return response()->json([
            'status' => true,
            'message' => 'Portfolio created!',
            'data' => $this->portfolioRepository->create($portfolioRequest->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Portfolio $portfolio
     * @param PortfolioRequest $portfolioRequest
     * @return JsonResponse
     */
    public function update(Portfolio $portfolio, PortfolioRequest $portfolioRequest)
    {
        if($this->portfolioRepository->update($portfolio, $portfolioRequest->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Portfolio updated!',
                'data' => $portfolio->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Portfolio $portfolio
     * @return JsonResponse
     */
    public function destroy(Portfolio $portfolio)
    {
        if($this->portfolioRepository->delete($portfolio)) {
            return response()->json([
                'status' => true,
                'message' => 'Portfolio deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
