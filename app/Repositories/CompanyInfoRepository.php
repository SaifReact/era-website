<?php

namespace App\Repositories;

use App\Models\CompanyInfo;

/**
 * Class CompanyInfoRepository
 * @package App\Repositories
 */
class CompanyInfoRepository extends Repository
{
    /**
     * CompanyInfoRepository constructor.
     * @param CompanyInfo $companyInfo
     */
    public function __construct(CompanyInfo $companyInfo)
    {
        parent::__construct($companyInfo);
    }
}
