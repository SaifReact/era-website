<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Client extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'client_name' => [
            'searchable' => true,
        ],
        'url' => [
            'searchable' => false,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $dataTableRelationships = [
        'belongsTo' => [
            'client_category' => [
                'model' => ClientCategory::class,
                'foreign_key' => 'client_category_id',
                'columns' => [
                    'category_name' => [
                        'searchable' => true,
                    ]
                ]
            ]
        ]
    ];

    protected $fillable = ['logo', 'client_name', 'client_category_id', 'url', 'order'];

    protected $with = ['client_category'];

    public function client_category()
    {
        return $this->belongsTo(ClientCategory::class);
    }
}
