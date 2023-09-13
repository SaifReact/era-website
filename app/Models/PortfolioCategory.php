<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LaravelVueDatatableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Contracts\Auditable;

class PortfolioCategory extends Model implements Auditable
{
    use HasFactory, Sluggable, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'category_name' => [
            'searchable' => true,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];


    protected $fillable = ['logo', 'category_name', 'slug', 'order'];

    protected $appends = ['text', 'value'];

    /**
     * @return mixed
     */
    public function getTextAttribute() {
        return $this->category_name;
    }

    /**
     * @return mixed
     */
    public function getValueAttribute() {
        return $this->id;
    }

    public function portfolios() {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name'
            ]
        ];
    }
}
