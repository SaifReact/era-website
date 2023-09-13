<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class ContactController
 * @package App\Http\Controllers\Api\Admin
 */
class ContactController extends Controller
{
    /** @var ContactRepository */
    private $contactRepository;

    /**
     * ContactController constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->contactRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function show(Contact $contact)
    {
        return response()->json([
            'status' => true,
            'message' => 'Contact showed!',
            'data' => $contact,
        ], Response::HTTP_OK);
    }

    public function store(ContactRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Contact created!',
            'data' => $this->contactRepository->create($request->post()),
        ], Response::HTTP_CREATED);
    }

    public function update(Contact $contact, ContactRequest $request)
    {
        if($this->contactRepository->update($contact, $request->post())) {
            return response()->json([
                'status' => true,
                'message' => 'Contact updated!',
                'data' => $contact->refresh(),
            ], Response::HTTP_OK);
        }
    }

    public function destroy(Contact $contact)
    {
        if($this->contactRepository->delete($contact)) {
            return response()->json([
                'status' => true,
                'message' => 'Contact deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
