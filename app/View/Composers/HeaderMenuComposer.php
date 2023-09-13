<?php

namespace App\View\Composers;

use App\Models\Menu;
use App\Repositories\MenuItemRepository;
use App\Repositories\MenuRepository;
use App\Repositories\PageRepository;
use App\Services\Contracts\MenuItemContract;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

/**
 * Class HeaderMenuComposer
 * @package App\View\Composers
 */
class HeaderMenuComposer extends UrlComposer
{
    const MAX_ELEMENT_WITHOUT_SCROLL= 13;

    /** @var MenuRepository */
    private $menuRepository;

    /** @var MenuItemContract */
    private $menuItemService;

    /**
     * HeaderMenuComposer constructor.
     * @param MenuRepository $menuRepository
     * @param PageRepository $pageRepository
     * @param MenuItemRepository $menuItemRepository
     * @param MenuItemContract $menuItemService
     */
    public function __construct(MenuRepository $menuRepository,
                                PageRepository $pageRepository,
                                MenuItemRepository $menuItemRepository,
                                MenuItemContract $menuItemService)
    {
        $this->menuRepository = $menuRepository;
        $this->menuItemService = $menuItemService;

        parent::__construct($pageRepository, $menuItemRepository);
    }

    public function compose(View $view)
    {
        $menuItems = $this->buildMenuItems();
        $view->with('headerMenuItems', $menuItems);
    }

    private function buildMenuItems()
    {
        $headerMenu = $this->menuRepository->findBySlug('header');
        $headerMenuItems = $this->menuItemService->getTreeStructure($headerMenu);

        $html = <<<OUTERHTML
<nav id="navbar" class="navbar">
{$this->buildTree($headerMenuItems)}
<i class="bi bi-list mobile-nav-toggle"></i>
</nav>
OUTERHTML;

        return $html;
    }

    /**
     * @param $elements
     * @return string
     */
    public function buildTree($elements)
    {
        if(count($elements) > self::MAX_ELEMENT_WITHOUT_SCROLL) {
            $innerHtml = '<ul class="overflowed-menu">';
        } else {
            $innerHtml = '<ul>';
        }

        foreach ($elements as $element) {
            $innerHtml .= '<li class="'.$this->getLiClass($element).'">'.$this->createElement($element).'</li>';
        }

        $innerHtml .= '</ul>';

        return $innerHtml;
    }

    /**
     * @param $element
     * @return string
     */
    private function createElement($element)
    {
        if($this->hasChild($element)) {
            $content = '<a href="'.$this->getUrl($element).'" target="'.$element['target'].'"><span>'.$element['name'].'</span>'.$this->getArrow($element).'</a>';
            $content .= $this->buildTree($element['children']);

            return $content;
        }

        return '<a class="'.$this->getAnchorClass($element).$this->getActiveClass($element).'" href="'.$this->getUrl($element).'" target="'.$element['target'].'">'.$element['name'].'</a>';
    }

    /**
     * @param $element
     * @return string
     */
    private function getArrow($element)
    {
        if($element['level'] > 0) {
            return '<i class="bi bi-chevron-right"></i>';
        }

        return '<i class="bi bi-chevron-down"></i>';
    }

    /**
     * @param $element
     * @return string
     */
    private function getLiClass($element)
    {
        if($this->hasChild($element)) {
            return 'dropdown';
        }

        return '';
    }

    /**
     * @param $element
     * @return string
     */
    private function getAnchorClass($element)
    {
        if(!$this->hasChild($element)) {
            return 'nav-link';
        }

        return '';
    }

    /**
     * @param $element
     * @return string
     */
    private function getActiveClass($element)
    {
        $currentPath = Request::path();
        $currentUrl = Request::url();

        $item = request()->get('item');

        if($item) {
            if(
                $this->customUrlMatches($currentPath, $element) ||
                $this->pageUrlMatches($currentUrl, $element) ||
                $this->itemMatches($item, $element)
            ) {
                return ' active';
            }
        } else {
            if(
                $this->customUrlMatches($currentPath, $element) ||
                $this->pageUrlMatches($currentUrl, $element)
            ) {
                return ' active';
            }
        }
    }

    /**
     * @param $currentPath
     * @param $element
     * @return bool
     */
    private function customUrlMatches($currentPath, $element)
    {
        return ($currentPath === $element['external_url']);
    }

    /**
     * @param $currentUrl
     * @param $element
     * @return bool
     */
    private function pageUrlMatches($currentUrl, $element)
    {
        return ( $element['page_id'] && ($currentUrl === $this->generatePageUrl($element['page_id'])) );
    }

    /**
     * @param $item
     * @param $element
     * @return bool
     */
    private function itemMatches($item, $element)
    {
        return ($item == $element['id']);
    }

    /**
     * @param $element
     * @return bool
     */
    private function hasChild($element)
    {
        return !empty($element['children']) && (count($element['children']) > 0);
    }
}
