<?php

namespace App\Services;

use App\Enums\Banner;
use App\Exceptions\BannerException;
use App\Repositories\BannerRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BannerService
 * @package App\Services
 */
class BannerService implements Contracts\BannerContract
{
    /** @var BannerRepository  */
    private $bannerRepository;

    /**
     * BannerService constructor.
     * @param BannerRepository $bannerRepository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @param array $arr
     * @return Model
     * @throws BannerException
     */
    public function add(array $arr): Model
    {
        if($this->bannerRepository->count() < Banner::MAXIMUM_BANNER_CAN_BE_ADDED)
            return $this->bannerRepository->create($arr);

        throw new BannerException(sprintf('More than %d banners is not permitted to add!',
            Banner::MAXIMUM_BANNER_CAN_BE_ADDED));
    }

    public function getSortedBanners() {
        return $this->bannerRepository->all()->sortBy('order');
    }
}
