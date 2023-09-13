<?php


namespace App\Services;


use App\Repositories\ProductRepository;

class ProductService implements Contracts\ProductContract
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getSortedProducts() {
        return $this->productRepository->all()->sortBy('order');
    }
}
