<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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

        $query = $this->productRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product showed!',
            'data' => $product,
        ], Response::HTTP_OK);
    }

    /**
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product created!',
            'data' => $this->productRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Product $product
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function update(Product $product, ProductRequest $request)
    {
        if($this->productRepository->update($product, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Product updated!',
                'data' => $product->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        if($this->productRepository->delete($product)) {
            return response()->json([
                'status' => true,
                'message' => 'Product deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
