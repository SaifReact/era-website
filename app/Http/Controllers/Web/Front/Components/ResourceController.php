<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\ResourceInfoContract;
use App\Services\IndexPageService;
use App\Services\ResourceInfoService;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /** @var ResourceInfoContract|ResourceInfoService */
    private $resourceInfoService;

    public function __construct(ResourceInfoContract $resourceInfoService)
    {
        $this->resourceInfoService = $resourceInfoService;
    }

    public function __invoke()
    {
        return view('web.front.components.resource', [
            'resourceInfo' => $this->resourceInfoService->get()
        ]);
    }
}
