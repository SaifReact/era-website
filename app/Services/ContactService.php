<?php


namespace App\Services;


use App\Repositories\ContactRepository;

class ContactService implements Contracts\ContactContract
{
    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getContact() {
        return $this->contactRepository->findPrimaryOrFirst();
    }
}
