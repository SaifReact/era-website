<?php


namespace App\Repositories;


use App\Models\Client;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientRepository
 * @package App\Repositories
 */
class ClientRepository extends Repository
{
    /**
     * ClientRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }
}
