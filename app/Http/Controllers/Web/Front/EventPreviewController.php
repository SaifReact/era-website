<?php

namespace App\Http\Controllers\Web\Front;

use App\Enums\EventStatus;
use App\Enums\Paginator;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class EventController
 * @package App\Http\Controllers\Web\Front
 */
class EventPreviewController extends Controller
{
    /** @var EventRepository */
    private $eventRepository;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Event $event
     * @return Application|Factory|View
     */
    public function show(Event $event)
    {
        abort_if(($event->status===EventStatus::PUBLISH_STRING), Response::HTTP_NOT_FOUND);
        $item = request()->get('item') ? request()->get('item') : null;

        return view('web.front.admin.event.show', compact('event','item'));
    }
}
