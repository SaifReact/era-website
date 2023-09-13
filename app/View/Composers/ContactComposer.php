<?php

namespace App\View\Composers;

use App\Repositories\ContactRepository;
use Illuminate\View\View;

/**
 * Class ContactComposer
 * @package App\View\Composers
 */
class ContactComposer
{
    /** @var ContactRepository */
    private $contactRepository;

    /**
     * ContactComposer constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function compose(View $view)
    {
        $view->with('contact', $this->contactRepository->findPrimaryOrFirst());
    }
}
