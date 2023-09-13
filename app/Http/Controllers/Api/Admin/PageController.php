<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class PageController
 * @package App\Http\Controllers\Api\Admin
 */
class PageController extends Controller
{
    /** @var PageRepository */
    private $pageRepository;

    /**
     * PageController constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
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

        $query = $this->pageRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Page $page
     * @return JsonResponse
     */
    public function show(Page $page)
    {
        return response()->json([
            'status' => true,
            'message' => 'Page showed!',
            'data' => $page,
        ], Response::HTTP_OK);
    }

    /**
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function store(PageRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Page created!',
            'data' => $this->pageRepository->create($request->getParams()),
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Page $page
     * @param PageRequest $request
     * @return JsonResponse
     */
    public function update(Page $page, PageRequest $request)
    {
        if ($this->pageRepository->update($page, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Page updated!',
                'data' => $page->refresh(),
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Page $page
     * @return JsonResponse
     */
    public function destroy(Page $page)
    {
        if ($this->pageRepository->delete($page)) {
            return response()->json([
                'status' => true,
                'message' => 'Page deleted!',
                'data' => null,
            ], Response::HTTP_OK);
        }
    }
}
