<?php

namespace App\View\Composers;

use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;
use App\Repositories\PageRepository;
use Illuminate\View\View;

/**
 * Class BreadCrumbComposer
 * @package App\View\Composers
 */
class BreadCrumbComposer extends UrlComposer
{
    /** @var string */
    private $homeListElement = '';

    /** @var MenuItemRepository */
    protected $menuItemRepository;

    /**
     * BreadCrumbComposer constructor.
     * @param MenuItemRepository $menuItemRepository
     * @param PageRepository $pageRepository
     */
    public function __construct(MenuItemRepository $menuItemRepository, PageRepository $pageRepository)
    {
        $this->homeListElement = '<li><a href="'.route('home').'">Home</a></li>';
        $this->menuItemRepository = $menuItemRepository;

        parent::__construct($pageRepository, $menuItemRepository);
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $menuItems = [];
        $breadcrumb = '';
        $currentItem = null;
        $item = request()->get('item');

        if($item) {
            $menuItem = $this->menuItemRepository->find($item);
            if($menuItem) {
                $menuItems = $this->collectMenuItems($menuItem);
                $breadcrumb = $this->createList($menuItems);
                $currentItem = $menuItem;
            }
        }

        $view->with('breadcrumb', $breadcrumb)->with('currentItem', $currentItem ? $currentItem->name : '');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function collectMenuItems(MenuItem $item)
    {
        if($item->parent) {
            $menuItems = $this->collectMenuItems($item->parent);
        }

        $menuItems[] = $item;

        return $menuItems;
    }

    /**
     * @param $menuItems
     * @return string
     */
    private function createList($menuItems)
    {
        $innerHtml = '<ol>';
        $innerHtml .= $this->homeListElement;

        if(count($menuItems) > 0) {
            foreach($menuItems as $menuItem) {
                $innerHtml .= '<li><a href="'.$this->getUrl($menuItem).'">'.$menuItem['name'].'</a></li>';
            }


        }
        $innerHtml .= '</ol>';

        return $innerHtml;
    }
}
