<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientContactRequest;
use App\Notifications\LeadMessageReached;
use App\Repositories\CompanyInfoRepository;
use App\Repositories\ContactRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

/**
 * Class ContactController
 * @package App\Http\Controllers\Web\Front
 */
class ContactController extends Controller
{
    /** @var CompanyInfoRepository */
    private $companyInfoRepository;

    /** @var ContactRepository */
    private $contactRepository;

    /** @var LocationRepository */
    private $locationRepository;

    /**
     * ContactController constructor.
     * @param CompanyInfoRepository $companyInfoRepository
     * @param ContactRepository $contactRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(CompanyInfoRepository $companyInfoRepository, ContactRepository $contactRepository,
                                LocationRepository $locationRepository)
    {
        $this->companyInfoRepository = $companyInfoRepository;
        $this->contactRepository = $contactRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $contacts = $this->contactRepository->all()->sortBy('order');
        $location = $this->locationRepository->first();
        $companyInfo = $this->companyInfoRepository->first();
        
        return view('web.front.contact.create', compact('contacts', 'location', 'companyInfo'));
    }

    /**
     * @param ClientContactRequest $request
     */
    public function store(ClientContactRequest $request)
    {
        try {
            Notification::send($this->companyInfoRepository->first(), new LeadMessageReached($request->post()));

            return response('OK')->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $e) {
            return response('ERROR')->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}