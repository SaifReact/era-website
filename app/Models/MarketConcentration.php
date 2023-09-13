<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LaravelVueDatatableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class MarketConcentration extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'title' => [
            'searchable' => true,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['image', 'title', 'order'];
}
