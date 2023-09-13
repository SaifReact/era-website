<?php

namespace App\Repositories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuItemRepository
 * @package App\Repositories
 */
class MenuItemRepository extends Repository
{
    /**
     * MenuItemRepository constructor.
     * @param MenuItem $menuItem
     */
    public function __construct(MenuItem $menuItem)
    {
        parent::__construct($menuItem);
    }

    public function deleteByMenuId($menuId)
    {
        return $this->getModel()->where(['menu_id' => $menuId])->delete();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->getModel()->findBySlug($slug);
    }
}
