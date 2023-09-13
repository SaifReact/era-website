<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'product_name' => [
            'searchable' => true,
        ],
        'url' => [
            'searchable' => false,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = ['logo', 'product_name', 'summary', 'url', 'box_color', 'order'];
}
