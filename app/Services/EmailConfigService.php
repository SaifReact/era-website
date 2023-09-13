<?php

namespace App\Services;

use App\Repositories\EmailConfigRepository;
use App\Services\Contracts\EmailConfigContract;

/**
 * Class EmailConfigService
 * @package App\Services
 */
class EmailConfigService implements EmailConfigContract
{
    /** @var EmailConfigRepository */
    private $emailConfigRepository;

    /**
     * EmailConfigService constructor.
     * @param EmailConfigRepository $emailConfigRepository
     */
    public function __construct(EmailConfigRepository $emailConfigRepository)
    {
        $this->emailConfigRepository = $emailConfigRepository;
    }

    public function getEmailConfig()
    {
        return $this->emailConfigRepository->first();
    }
}
