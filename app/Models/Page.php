<?php

namespace App\Models;

use App\Enums\PageStatus;
use App\Models\Traits\LaravelVueDatatableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Page extends Model implements Auditable
{
    use HasFactory, Sluggable, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ],
        'slug' => [
            'searchable' => true,
        ],
        'meta' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => false,
        ]
    ];

    protected $fillable = ['title', 'slug', 'content', 'meta', 'status'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @param $status
     */
    public function getStatusAttribute($status)
    {
        if($status === PageStatus::DRAFT) {
            return PageStatus::DRAFT_STRING;
        } else if($status === PageStatus::PUBLISH) {
            return PageStatus::PUBLISH_STRING;
        }
    }
}
