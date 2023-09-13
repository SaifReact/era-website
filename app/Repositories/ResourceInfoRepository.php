<?php

namespace App\Repositories;

use App\Models\ResourceInfo;

/**
 * Class ResourceInfoRepository
 * @package App\Repositories
 */
class ResourceInfoRepository extends Repository
{
    /**
     * ResourceInfoRepository constructor.
     * @param ResourceInfo $resourceInfo
     */
    public function __construct(ResourceInfo $resourceInfo)
    {
        parent::__construct($resourceInfo);
    }
}
