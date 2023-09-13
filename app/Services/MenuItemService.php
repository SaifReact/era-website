<?php

namespace App\Services;

use App\Enums\Target;
use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;
use App\Services\Contracts\MenuItemContract;
use Illuminate\Support\Facades\DB;

/**
 * Class MenuItemService
 * @package App\Services
 */
class MenuItemService implements MenuItemContract
{
    /** @var string */
    private const LEVEL ='level';

    /** @var string  */
    private const PAGE = 'Page';

    /** @var string */
    private const CUSTOM = 'Custom link';

    /** @var string */
    private const ORIGINAL_NAME_KEY = 'original_name';

    /** @var string */
    private const NAME_KEY = 'name';

    /** @var string */
    private const SHOW_KEY = 'show';

    /** @var string */
    private const TYPE_KEY = 'type';

    /** @var string */
    private const PAGE_ID_KEY = 'page_id';

    /** @var string */
    private const CHILDREN_KEY = 'children';

    /** @var string */
    private const PARENT_ID_KEY = 'parent_id';

    /** @var string */
    private const ID_KEY = 'id';

    /** @var string */
    public const TARGET_KEY = 'target';

    /** @var MenuItemRepository */
    private $menuItemRepository;

    /**
     * MenuItemService constructor.
     * @param MenuItemRepository $menuItemRepository
     */
    public function __construct(MenuItemRepository $menuItemRepository)
    {
        $this->menuItemRepository = $menuItemRepository;
    }

    /**
     * @param array $params
     */
    public function addCollection(array $params)
    {
        DB::beginTransaction();
        try {
            if(!$params['menu']['id']) {
                throw new \Exception('No menu selected!');
            }

            if(!$params['menuItems']) {
                throw new \Exception('No menu items selected!');
            }

            $this->menuItemRepository->deleteByMenuId($params['menu']['id']);
            $this->addMenuItem($params['menuItems']);
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * @param $elements
     * @param int $parentId
     * @return array
     */
    public function buildTree($elements, $parentId = 0) {
        $branch = [];

        foreach ($elements as $element) {
            $element[self::SHOW_KEY] = false;
            $element[self::TYPE_KEY] = (!empty($element[self::PAGE_ID_KEY])) ? self::PAGE : self::CUSTOM;
            $element[self::ORIGINAL_NAME_KEY] = $element[self::NAME_KEY];

            if (
            ($element[self::PARENT_ID_KEY] == $parentId)
            ) {
                $children = $this->buildTree($elements, $element[self::ID_KEY]);
                if ($children) {
                    $element[self::CHILDREN_KEY] = $children;
                }

                $branch[] = $element;
                unset($element);
            }
        }

        return $branch;
    }

    /**
     * @param $menu
     * @return array
     */
    public function getTreeStructure($menu) {
        if($menu->menuItems)
            return $this->buildTree($menu->menuItems->toArray());

        return [];
    }

    /**
     * @param array $menuItems
     * @param int $level
     * @param null $inserted
     */
    private function addMenuItem(array $menuItems, $level = 0, $inserted = null)
    {
        foreach($menuItems as $menuItem) {
            $insertedMenuItem = $this->menuItemRepository->create($this->reconcileMenuItem($menuItem, $level, $inserted));

            if(is_array($menuItem) &&
                array_key_exists(self::CHILDREN_KEY, $menuItem) &&
                count($menuItem[self::CHILDREN_KEY]) > 0
            ) {
                $this->addMenuItem($menuItem[self::CHILDREN_KEY], $level + 1, $insertedMenuItem);
            }
        }
    }

    /**
     * @param $menuItem
     * @param int $level
     * @param null $inserted
     * @return mixed
     */
    private function reconcileMenuItem($menuItem, $level = 0, $inserted = null)
    {
        if($inserted) {
            $menuItem[self::PARENT_ID_KEY] = $inserted->id;
        } else {
            $menuItem[self::PARENT_ID_KEY] = null;
        }

        if($this->isTargetEmpty($menuItem)) {
            $menuItem[self::TARGET_KEY] = Target::SELF;
        }

        $menuItem[self::LEVEL] = $level;

        return $menuItem;
    }

    public function isTargetEmpty($menuItem)
    {
        return ($menuItem[self::TARGET_KEY] === '');
    }
}
