<?php

namespace App\Repositories;

use App\Models\EmailConfig;

/**
 * Class EmailConfigRepository
 * @package App\Repositories
 */
class EmailConfigRepository extends Repository
{
    /**
     * EmailConfigRepository constructor.
     * @param EmailConfig $model
     */
    public function __construct(EmailConfig $model)
    {
        parent::__construct($model);
    }
}
