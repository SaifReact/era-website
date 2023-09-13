<?php


namespace App\Repositories;


use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EventRepository
 * @package App\Repositories
 */
class EventRepository extends Repository
{
    /**
     * EventRepository constructor.
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    public function published()
    {
        return $this->getModel()->published();
    }

    /**
     * @param $event
     * @return mixed
     */
    public function findNext($event)
    {
        return $this->getModel()->select(['id', 'slug', 'title'])->published()->where('id', '>', $event->id)->orderBy('id')->first();
    }

    /**
     * @param $event
     * @return mixed
     */
    public function findPrevious($event)
    {
        return $this->getModel()->select(['id', 'slug', 'title'])->published()->where('id', '<', $event->id)->orderBy('id','desc')->first();
    }

    /**
     * @param $number
     * @return mixed
     */
    public function findLatestPublishedEvents($number)
    {
        return $this->getModel()->select([
            'id', 'title', 'slug', 'meta', 'thumbnail', 'event_at'
        ])->published()
            ->latest('publish_at')
            ->latest('id')
            ->take($number)
            ->get();
    }
}
