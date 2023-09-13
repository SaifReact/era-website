<?php

namespace App\Models;

use App\Models\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Portfolio extends Model implements Auditable
{
    use HasFactory, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'order' => [
            'searchable' => true,
        ]
    ];

    protected $dataTableRelationships = [
        'belongsTo' => [
            'portfolio_category' => [
                'model' => PortfolioCategory::class,
                'foreign_key' => 'portfolio_category_id',
                'columns' => [
                    'category_name' => [
                        'searchable' => true,
                    ]
                ]
            ]
        ]
    ];

    protected $fillable = ['thumbnail', 'image', 'name', 'portfolio_category_id', 'detail', 'order'];

    protected $with = ['portfolio_category'];

    public function portfolio_category()
    {
        return $this->belongsTo(PortfolioCategory::class);
    }
}
