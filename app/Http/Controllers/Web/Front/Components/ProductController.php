<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\ProductContract;
use App\Services\IndexPageService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** @var ProductContract|ProductService */
    private $productService;

    public function __construct(ProductContract $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke()
    {
        return view('web.front.components.products', [
            'products' => $this->productService->getSortedProducts(),
        ]);
    }
}
