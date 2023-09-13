<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use App\Repositories\PageRepository;
use App\Services\Contracts\MenuItemContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class MenuController
 * @package App\Http\Controllers\Api\Admin
 */
class MenuController extends Controller
{
    /** @var MenuRepository */
    private $menuRepository;

    /** @var PageRepository */
    private $pageRepository;

    /** @var MenuItemContract */
    private $menuItemService;


    public function __construct(MenuRepository $menuRepository, PageRepository $pageRepository,
                                MenuItemContract $menuItemService)
    {
        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
        $this->menuItemService = $menuItemService;
    }

    /**
     * @param Request $request
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->menuRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function show(Menu $menu)
    {
        $data = [
            'menu' => $menu,
            'menuItems' => $this->menuItemService->getTreeStructure($menu),
            'pages' => $this->pageRepository->all(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Menu showed!',
            'data' => $data,
        ], Response::HTTP_OK);
    }

    /**
     * @param MenuRequest $request
     * @return JsonResponse
     */
    public function store(MenuRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Menu created!',
            'data' => $this->menuRepository->create($request->getParams()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Menu $menu
     * @param MenuRequest $request
     * @return JsonResponse
     */
    public function update(Menu $menu, MenuRequest $request)
    {
        if($this->menuRepository->update($menu, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Menu updated!',
                'data' => $menu->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function destroy(Menu $menu)
    {
        if($this->menuRepository->delete($menu)) {
            return response()->json([
                'status' => true,
                'message' => 'Menu deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
