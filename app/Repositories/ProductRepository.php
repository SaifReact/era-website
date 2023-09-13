<?php


namespace App\Repositories;


use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository extends Repository
{
    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
}
