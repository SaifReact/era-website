<?php


namespace App\Services;


use App\Repositories\EventRepository;

class EventService implements Contracts\EventContract
{
    /** @var EventRepository */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getLatestPublished($numberOfEvents) {
        return $this->eventRepository->findLatestPublishedEvents($numberOfEvents);
    }
}
