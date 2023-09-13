<?php


namespace App\Services;


use App\Repositories\ResourceInfoRepository;

class ResourceInfoService implements Contracts\ResourceInfoContract
{
    /** @var ResourceInfoRepository */
    private $resourceInfoRepository;

    public function __construct(ResourceInfoRepository $resourceInfoRepository)
    {
        $this->resourceInfoRepository = $resourceInfoRepository;
    }

    public function get() {
        return $this->resourceInfoRepository->first();
    }
}
