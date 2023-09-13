<?php


namespace App\Services;


use App\Repositories\CompanyInfoRepository;

class CompanyInfoService implements Contracts\CompanyInfoContract
{
    /** @var CompanyInfoRepository */
    private $companyInfoRepository;

    public function __construct(CompanyInfoRepository $companyInfoRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
    }

    public function getCompanyInfo() {
        return $this->companyInfoRepository->first();
    }
}
