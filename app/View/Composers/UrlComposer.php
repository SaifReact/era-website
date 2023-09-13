<?php


namespace App\View\Composers;


use App\Repositories\MenuItemRepository;
use App\Repositories\PageRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UrlComposer
{
    /**
     * @var PageRepository
     */
    protected $pageRepository;

    /**
     * @var MenuItemRepository
     */
    protected $menuItemRepository;

    /**
     * UrlComposer constructor.
     * @param PageRepository $pageRepository
     * @param MenuItemRepository $menuItemRepository
     */
    public function __construct(PageRepository $pageRepository, MenuItemRepository $menuItemRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->menuItemRepository = $menuItemRepository;
    }

    /**
     * @param $element
     * @return mixed|string
     */
    protected function getUrl($element)
    {
        if($element['page_id']) {
            return $this->generatePageUrl($element['page_id']).'?item='.$element['id'];
        } else {
            if($this->contains('http', $element['external_url'])) {
                return $element['external_url'];
            }
            /*else if( ($element['external_url'] === '/contacts') ) {
                $itemParam = Request::get('item', '');
                $menuItem = null;

                if($itemParam) {
                    $menuItem = $this->menuItemRepository->find($itemParam);

                }

                if(
                    $this->isBaseUrl($itemParam, $menuItem)
                ) {
                    return '#contact'; // FIXME: Hardcoded ID!
                }
            }*/


            return $element['external_url'].'?item='.$element['id'];
        }
    }

    /**
     * @param $itemParam
     * @param $menuItem
     * @return bool
     */
    private function isBaseUrl($itemParam, $menuItem)
    {
        return (!$itemParam || ($menuItem && ($menuItem->external_url === '/') || ($menuItem->external_url === '')));
    }

    /**
     * @param $searchTerm
     * @param $text
     * @return bool
     */
    private function contains($searchTerm, $text)
    {
        return str_contains($text, $searchTerm);
    }

    /**
     * @param $pageId
     * @return string
     */
    protected function generatePageUrl($pageId)
    {
        $page = $this->pageRepository->find($pageId);
        return route('page-show', [$page->slug]);
    }

    /*private function reserved()
    {
        if(
        Str::startsWith($element['external_url'], '#') &&
        (Str::length($element['external_url']) > 1)
        ) {
        $currentUrl = URL::current();
        $itemParam = Request::get('item', '');
        $hashTagUrl = $currentUrl.'/'.$element['external_url'];

        if($itemParam) {
        $hashTagUrl .= '?item='.$element['id'];
        }

        return $hashTagUrl;
        }

    }*/
}
