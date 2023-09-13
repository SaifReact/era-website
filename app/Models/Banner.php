<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LaravelVueDatatableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Banner extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'banner_text' => [
            'searchable' => true,
        ],
        'button_text' => [
            'searchable' => true,
        ],
        'button_url' => [
            'searchable' => false,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $fillable = [
        'banner_image', 'banner_text', 'button_text', 'button_url', 'order'
    ];
}
