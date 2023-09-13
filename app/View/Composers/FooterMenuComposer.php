<?php

namespace App\View\Composers;

use App\Repositories\CompanyInfoRepository;
use App\Repositories\MenuItemRepository;
use App\Repositories\MenuRepository;
use App\Repositories\PageRepository;
use App\Services\Contracts\MenuItemContract;
use Illuminate\View\View;

/**
 * Class FooterMenuComposer
 * @package App\View\Composers
 */
class FooterMenuComposer extends UrlComposer
{
    /** @var MenuRepository */
    private $menuRepository;

    /** @var MenuItemContract */
    private $menuItemService;

    /**
     * FooterMenuComposer constructor.
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

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $menuItems = $this->buildMenuItems();
        $view->with('footerMenuItems', $menuItems);
    }

    /**
     * @return string
     */
    private function buildMenuItems()
    {
        $footerMenu = $this->menuRepository->findBySlug('footer');
        $footerMenuItems = $this->menuItemService->getTreeStructure($footerMenu);

        $html = <<<OUTERHTML
{$this->createMenu($footerMenuItems)}
OUTERHTML;

        return $html;
    }

    /**
     * @param $elements
     * @return string
     */
    public function createMenu($elements)
    {
        $innerHtml = '';

        foreach ($elements as $element) {
            $innerHtml .= '<div class="col-lg col footer-links">';
            $innerHtml .= "<h4>".$element['name']."</h4>";
            $innerHtml .= $this->createElement($element);
            $innerHtml .= "</div>";
        }

        return $innerHtml;
    }

    /**
     * @param $elements
     * @return string
     */
    public function buildTree($elements)
    {
        $innerHtml = "<ul>";

        foreach ($elements as $element) {
            $innerHtml .= '<li><i class="bi bi-chevron-right"></i>'.$this->createElement($element).'</li>';
        }

        $innerHtml .= "</ul>";

        return $innerHtml;
    }

    /**
     * @param $element
     * @return string
     */
    private function createElement($element)
    {
        if($this->hasChild($element)) {
            return $this->buildTree($element['children']);
        }

        return '<a href="'.$this->getUrl($element).'" target="'.$element['target'].'">'.$element['name'].'</a>';
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
