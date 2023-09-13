<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LaravelVueDatatableTrait;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use OwenIt\Auditing\Contracts\Auditable;

class Menu extends Model implements Auditable
{
    use HasFactory, Sluggable, SluggableScopeHelpers, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'slug' => [
            'searchable' => true,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['name', 'order'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
