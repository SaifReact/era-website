<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\IndexPageService;

class IndexController extends Controller
{
    /** @var IndexPageContract|IndexPageService */
    private $indexPageService;

    public function __construct(IndexPageContract $indexPageService)
    {
        $this->indexPageService = $indexPageService;
    }

    public function index()
    {
        return view('web.front.index.index', $this->indexPageService->all());
    }
}
