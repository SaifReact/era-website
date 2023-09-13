<?php

namespace App\Repositories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PageRepository
 * @package App\Repositories
 */
class PageRepository extends Repository
{
    /**
     * PageRepository constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        parent::__construct($page);
    }
}
