<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\MenuItem;
use App\Repositories\MenuItemRepository;
use App\Services\Contracts\MenuItemContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MenuItemController
 * @package App\Http\Controllers\Api\Admin
 */
class MenuItemController extends Controller
{
    /** @var MenuItemRepository */
    private $menuItemRepository;

    /** @var MenuItemContract */
    private $menuItemService;

    /**
     * MenuItemController constructor.
     * @param MenuItemRepository $menuItemRepository
     * @param MenuItemContract $menuItemService
     */
    public function __construct(MenuItemRepository $menuItemRepository, MenuItemContract $menuItemService)
    {
        $this->menuItemRepository = $menuItemRepository;
        $this->menuItemService = $menuItemService;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Menu Item listed!',
            'data' => $this->menuItemRepository->all(),
        ], Response::HTTP_OK);
    }

    public function balkStore(Request $request)
    {
        try {
            $params = $request->post();
            $this->menuItemService->addCollection($params);
            return response()->json([
                'status' => true,
                'message' => "Menu Item assigned to {$params['menu']['name']} menu!",
                'data' => [],
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Menu Item not assigned to {$params['menu']['name']} menu!",
                'data' => [],
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param MenuItemRequest $request
     * @return JsonResponse
     */
    public function store(MenuItemRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Menu Item created!',
            'data' => $this->menuItemRepository->create($request->getParams()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param MenuItem $menuItem
     * @param MenuItemRequest $request
     * @return JsonResponse
     */
    public function update(MenuItem $menuItem, MenuItemRequest $request)
    {
        if($this->menuItemRepository->update($menuItem, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Menu Item updated!',
                'data' => $menuItem->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param MenuItem $menuItem
     * @return JsonResponse
     */
    public function destroy(MenuItem $menuItem)
    {
        if($this->menuItemRepository->delete($menuItem)) {
            return response()->json([
                'status' => true,
                'message' => 'Menu Item deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
