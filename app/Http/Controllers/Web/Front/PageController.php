<?php

namespace App\Http\Controllers\Web\Front;

use App\Enums\PageStatus;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PageController
 * @package App\Http\Controllers\Web\Front
 */
class PageController extends Controller
{
    public function show(Page $page)
    {
        abort_if(($page->status===PageStatus::DRAFT_STRING), Response::HTTP_NOT_FOUND);
        return view('web.front.page.show', compact('page'));
    }
}
