<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\AboutUsService;
use App\Services\Contracts\AboutUsContract;
use App\Services\Contracts\IndexPageContract;
use App\Services\IndexPageService;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /** @var AboutUsContract|AboutUsService */
    private $aboutUsService;

    public function __construct(AboutUsContract $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }

    public function __invoke()
    {
        return view('web.front.components.about-us', [
            'aboutUs' => $this->aboutUsService->get()
        ]);
    }
}
