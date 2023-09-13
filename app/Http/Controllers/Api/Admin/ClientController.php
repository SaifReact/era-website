<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class ClientController
 * @package App\Http\Controllers\Api\Admin
 */
class ClientController extends Controller
{
    /** @var ClientRepository */
    private $clientRepository;

    /**
     * ClientController constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param Request $request
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->clientRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function show(Client $client)
    {
        return response()->json([
            'status' => true,
            'message' => 'Client showed!',
            'data' => $client
        ], Response::HTTP_OK);
    }

    /**
     * @param ClientRequest $request
     * @return JsonResponse
     */
    public function store(ClientRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Client created!',
            'data' => $this->clientRepository->create($request->post())
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Client $client
     * @param ClientRequest $request
     * @return JsonResponse
     */
    public function update(Client $client, ClientRequest $request)
    {
        if($this->clientRepository->update($client, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Client updated!',
                'data' => $client->refresh()
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Client $client
     * @return JsonResponse
     */
    public function destroy(Client $client)
    {
        if($this->clientRepository->delete($client)) {
            return response()->json([
                'status' => true,
                'message' => 'Client deleted!',
                'data' => null
            ], Response::HTTP_OK);
        }
    }
}
