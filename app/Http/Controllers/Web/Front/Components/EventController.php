<?php

namespace App\Http\Controllers\Web\Front\Components;

use App\Http\Controllers\Controller;
use App\Services\Contracts\EventContract;
use App\Services\Contracts\IndexPageContract;
use App\Services\EventService;
use App\Services\IndexPageService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /** @var EventContract|EventService */
    private $eventService;

    public function __construct(EventContract $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke()
    {
        return view('web.front.components.events', [
            'events' => $this->eventService->getLatestPublished(3),
        ]);
    }
}
