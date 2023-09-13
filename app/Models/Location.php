<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Location extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'location_name' => [
            'searchable' => true,
        ],
        'address' => [
            'searchable' => true,
        ],
        'map_location' => [
            'searchable' => false,
        ],
        'lat' => [
            'searchable' => true,
        ],
        'lng' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['location_name', 'address', 'map_location', 'lat', 'lng'];
}
