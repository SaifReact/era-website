<?php


namespace App\Services;


use App\Repositories\ClientCategoryRepository;

class ClientCategoryService implements Contracts\ClientCategoryContract
{
    /** @var ClientCategoryRepository */
    private $clientCategoryRepository;

    public function __construct(ClientCategoryRepository $clientCategoryRepository)
    {
        $this->clientCategoryRepository = $clientCategoryRepository;
    }

    public function getCategoriesWithOrderedClients() {
        return $this->clientCategoryRepository->categoriesWithOrderedClients();
    }
}
