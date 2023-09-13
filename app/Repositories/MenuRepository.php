<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuRepository
 * @package App\Repositories
 */
class MenuRepository extends Repository
{
    /**
     * MenuRepository constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function findBySlug($slug)
    {
        return $this->getModel()->findBySlug($slug);
    }
}
