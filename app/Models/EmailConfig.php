<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmailConfig extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['active', 'mailer', 'host', 'port', 'username', 'password', 'encryption', 'from_address', 'from_name'];

    protected $casts = [
        'active' => 'boolean',
        'mailer' => 'string',
        'host' => 'string',
        'port' => 'integer',
        'username' => 'string',
        'password' => 'string',
        'encryption' => 'string',
        'from_address' => 'string',
        'from_name' => 'string'
    ];
}
