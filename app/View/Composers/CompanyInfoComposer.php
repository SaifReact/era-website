<?php

namespace App\View\Composers;

use App\Repositories\CompanyInfoRepository;
use Illuminate\View\View;

/**
 * Class CompanyInfoComposer
 * @package App\View\Composers
 */
class CompanyInfoComposer
{
    /** @var CompanyInfoRepository */
    private $companyInfoRepository;

    /**
     * CompanyInfoComposer constructor.
     * @param CompanyInfoRepository $companyInfoRepository
     */
    public function __construct(CompanyInfoRepository $companyInfoRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
    }

    public function compose(View $view)
    {
        $view->with('companyInfo', $this->companyInfoRepository->first());
    }
}
