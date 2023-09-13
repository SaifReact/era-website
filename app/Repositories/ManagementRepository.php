<?php

namespace App\Repositories;

use App\Models\Management;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ManagementRepository
 * @package App\Repositories
 */
class ManagementRepository extends Repository
{
    /**
     * ManagementRepository constructor.
     * @param Management $management
     */
    public function __construct(Management $management)
    {
        parent::__construct($management);
    }
}
