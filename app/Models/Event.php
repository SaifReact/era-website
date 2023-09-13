<?php

namespace App\Models;

use App\Enums\DateFormat;
use App\Enums\DateTimeFormat;
use App\Enums\EventStatus;
use App\Models\Traits\LaravelVueDatatableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Contracts\Auditable;

class Event extends Model implements Auditable
{
    use HasFactory, Sluggable, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ],
        'event_at' => [
            'searchable' => true,
        ],
        'publish_at' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => false,
        ]
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'slug', 'meta', 'thumbnail', 'image', 'event_at', 'teaser', 'detail', 'status', 'publish_at'];

    protected $dates= ['event_at', 'publish_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @param $timestamp
     */
    public function setEventAtAttribute($timestamp)
    {
        $this->attributes['event_at'] = DateFormat::store($timestamp);
    }

    /**
     * @param $timestamp
     */
    public function setPublishAtAttribute($timestamp)
    {
        $this->attributes['publish_at'] = DateTimeFormat::store($timestamp);
    }

    /**
     * @param $timestamp
     * @return string
     */
    public function getEventAtAttribute($timestamp)
    {
        return Carbon::parse($timestamp)->format(DateFormat::STORE);
    }

    /**
     * @param $timestamp
     * @return string
     */
    public function getPublishAtAttribute($timestamp)
    {
        return Carbon::parse($timestamp)->format(DateTimeFormat::STORE);
    }

    /**
     * @param $status
     */
    public function getStatusAttribute($status)
    {
        if($status === EventStatus::DRAFT) {
            return EventStatus::DRAFT_STRING;
        } else if($status === EventStatus::PUBLISH) {
            return EventStatus::PUBLISH_STRING;
        }
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where([
            ['publish_at', '<=', $this->publish_at],
            ['status', null]
        ]);
    }
}
