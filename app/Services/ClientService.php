<?php


namespace App\Services;


use App\Repositories\ClientRepository;

class ClientService implements Contracts\ClientContract
{
    /** @var ClientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getCount() {
        return $this->clientRepository->count();
    }
}
