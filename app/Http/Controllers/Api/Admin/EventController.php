<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class EventController
 * @package App\Http\Controllers\Api\Admin
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
     * @param Request $request
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->eventRepository->eloquentQuery($sortBy, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function show(Event $event)
    {
        return response()->json([
            'status' => true,
            'message' => 'Event showed!',
            'data' => $event
        ], Response::HTTP_OK);
    }

    /**
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function store(EventRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Event created!',
            'data' => $this->eventRepository->create($request->getParams())
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Event $event
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function update(Event $event, EventRequest $request)
    {
        if($this->eventRepository->update($event, $request->getParams())) {
            return response()->json([
                'status' => true,
                'message' => 'Event updated!',
                'data' => $event->refresh()
            ], Response::HTTP_OK);
        }
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function destroy(Event $event)
    {
        if($this->eventRepository->delete($event)) {
            return response()->json([
                'status' => true,
                'message' => 'Event deleted!',
                'data' => null
            ], Response::HTTP_OK);
        }
    }
}
