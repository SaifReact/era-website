<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IndexPageContract;
use App\Services\Contracts\ManagementContract;
use App\Services\IndexPageService;
use App\Services\ManagementService;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /** @var ManagementContract|ManagementService */
    private $managementService;

    public function __construct(ManagementContract $managementService)
    {
        $this->managementService = $managementService;
    }

    public function __invoke()
    {
        return view('web.front.components.managements', [
            'managements' => $this->managementService->getSortedManagements()
        ]);
    }
}
