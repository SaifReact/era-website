<?php

namespace App\Repositories;

use App\Models\Contact;

/**
 * Class ContactRepository
 * @package App\Repositories
 */
class ContactRepository extends Repository
{
    /**
     * ContactRepository constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
    }

    /**
     * @return mixed
     */
    public function findPrimaryOrFirst()
    {
        $contact = $this->getModel()->where('primary_contact', true)->first();

        if(!$contact) {
            $contact = $this->getModel()->first();
        }

        return $contact;
    }
}
