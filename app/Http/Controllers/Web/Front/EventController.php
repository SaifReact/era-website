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
class EventController extends Controller
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
     * @return Application|Factory|View
     */
    public function index()
    {
        $events = Event::select([
            'id', 'title', 'slug', 'meta', 'thumbnail', 'image', 'event_at', 'teaser', 'publish_at'
        ])->published()
            ->when(request()->get('event_at'), function(Builder $builder) {
                $builder->where('event_at', request()->get('event_at'));
            })
            ->latest('publish_at')
            ->latest('id')
            ->paginate(Paginator::NUMBER_OF_EVENTS);

        $item = request()->get('item') ? request()->get('item') : null;

        return view('web.front.event.index', ['events' => $events->appends(['item' => $item]), 'item' => $item]);
    }

    /**
     * @param Event $event
     * @return Application|Factory|View
     */
    public function show(Event $event)
    {
        abort_if(($event->status===EventStatus::DRAFT_STRING), Response::HTTP_NOT_FOUND);
        $item = request()->get('item') ? request()->get('item') : null;

        $nextEvent = $this->eventRepository->findNext($event);
        $previousEvent = $this->eventRepository->findPrevious($event);

        return view('web.front.event.show', compact('event', 'nextEvent', 'previousEvent', 'item'));
    }
}
