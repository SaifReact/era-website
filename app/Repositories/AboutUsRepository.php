<?php


namespace App\Repositories;


use App\Models\AboutUs;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AboutUsRepository
 * @package App\Repositories
 */
class AboutUsRepository extends Repository
{
    /**
     * AboutUsRepository constructor.
     * @param AboutUs $aboutUs
     */
    public function __construct(AboutUs $aboutUs)
    {
        parent::__construct($aboutUs);
    }
}
