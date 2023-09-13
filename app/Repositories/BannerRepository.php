<?php

namespace App\Repositories;

use App\Models\Banner;

/**
 * Class BannerRepository
 * @package App\Repositories
 */
class BannerRepository extends Repository
{
    /**
     * BannerRepository constructor.
     * @param Banner $banner
     */
    public function __construct(Banner $banner)
    {
        parent::__construct($banner);
    }
}
