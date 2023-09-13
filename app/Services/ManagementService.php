<?php


namespace App\Services;


use App\Repositories\ManagementRepository;

class ManagementService implements Contracts\ManagementContract
{
    /** @var ManagementRepository */
    private $managementRepository;

    public function __construct(ManagementRepository $managementRepository)
    {
        $this->managementRepository = $managementRepository;
    }

    public function getSortedManagements() {
        return $this->managementRepository->all()->sortBy('order');
    }
}
