<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use OwenIt\Auditing\Contracts\Auditable;

class MenuItem extends Model implements Auditable
{
    use HasFactory, Sluggable, SluggableScopeHelpers, \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'menu_id', 'page_id', 'level', 'parent_id', 'external_url', 'target'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenNested()
    {
        return $this->hasMany(self::class,'parent_id')->with('childrenNested');
    }
}
