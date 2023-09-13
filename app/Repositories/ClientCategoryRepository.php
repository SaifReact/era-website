<?php

namespace App\Repositories;


use App\Models\ClientCategory;

/**
 * Class ClientCategoryRepository
 * @package App\Repositories
 */
class ClientCategoryRepository extends Repository
{
    /**
     * ClientCategoryRepository constructor.
     * @param ClientCategory $clientCategory
     */
    public function __construct(ClientCategory $clientCategory)
    {
        parent::__construct($clientCategory);
    }

    public function categoriesWithOrderedClients()
    {
        return $this->getModel()
            ->with('orderedClients')
            ->withCount(['orderedClients'])
            ->orderBy('order')->get();
    }
}
