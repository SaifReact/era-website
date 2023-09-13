<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Testimonial extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'client_name' => [
            'searchable' => true,
        ],
        'person_name' => [
            'searchable' => true,
        ],
        'designation' => [
            'searchable' => true,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['photo', 'client_name', 'person_name', 'designation', 'message', 'order'];
}
