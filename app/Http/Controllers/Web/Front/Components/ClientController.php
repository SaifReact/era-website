<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\ClientCategoryService;
use App\Services\ClientService;
use App\Services\Contracts\ClientCategoryContract;
use App\Services\Contracts\ClientContract;
use App\Services\Contracts\IndexPageContract;
use App\Services\IndexPageService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /** @var ClientCategoryContract|ClientCategoryService */
    private $clientCategoryService;

    /** @var ClientContract|ClientService */
    private $clientService;

    public function __construct(ClientCategoryContract $clientCategoryService, ClientContract $clientService)
    {
        $this->clientCategoryService = $clientCategoryService;
        $this->clientService = $clientService;
    }

    public function __invoke()
    {
        return view('web.front.components.clients', [
            'clientsCount' => $this->clientService->getCount(),
            'clientCategoriesWithClients' => $this->clientCategoryService->getCategoriesWithOrderedClients()
        ]);
    }
}
