<?php

namespace App\Services;

use App\Services\Contracts\BannerContract;
use App\Services\Contracts\CompanyInfoContract;
use App\Services\Contracts\ContactContract;
use App\Services\Contracts\LocationContract;
use App\Services\Contracts\MarketConcentrationContract;
use App\Services\Contracts\ResourceInfoContract;

/**
 * Class IndexPageService
 * @package App\Services
 */
class IndexPageService implements Contracts\IndexPageContract
{
    /** @var CompanyInfoService */
    private $companyInfoService;

    /** @var ContactService */
    private $contactService;

    /** @var LocationService */
    private $locationService;

    /** @var BannerService */
    private $bannerService;

    /** @var ResourceInfoService */
    private $resourceInfoService;

    /** @var MarketConcentrationService */
    private $marketConcentrationService;


    public function __construct(CompanyInfoContract $companyInfoService, ContactContract $contactService,
                                LocationContract $locationService,  BannerContract $bannerService,
                                ResourceInfoContract $resourceInfoService,
                                MarketConcentrationContract $marketConcentrationService)
    {
        $this->companyInfoService = $companyInfoService;
        $this->contactService = $contactService;
        $this->locationService = $locationService;
        $this->bannerService = $bannerService;
        $this->resourceInfoService = $resourceInfoService;
        $this->marketConcentrationService = $marketConcentrationService;
    }

    public function all()
    {
        return ['companyInfo' => $this->companyInfoService->getCompanyInfo(),
            'contact' => $this->contactService->getContact(),
            'location' => $this->locationService->getLocation(),
            'banners' => $this->bannerService->getSortedBanners(),
            'resourceInfo' => $this->resourceInfoService->get(),
            'marketConcentrations' => $this->marketConcentrationService->getSortedMarketConcentrations(),
        ];
    }
}
