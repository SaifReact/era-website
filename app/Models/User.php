<?php

namespace App\Models;

use App\Contracts\UserCreateNotifiable;
use App\Enums\DateTimeFormat;
use App\Models\Traits\LaravelVueDatatableTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\UserUpdateNotifiable;
use App\Contracts\UserPasswordChangedNotifiable;
use App\Concerns\UpdateUser as UpdateUserTrait;
use App\Concerns\CreateUser as CreateUserTrait;
use App\Concerns\ChangeUserPassword as ChangeUserPasswordTrait;

class User extends Authenticatable implements Auditable, UserCreateNotifiable, UserUpdateNotifiable,
    UserPasswordChangedNotifiable
{
    use HasFactory, Notifiable, CanResetPassword, HasApiTokens, LaravelVueDatatableTrait, \OwenIt\Auditing\Auditable,
        CreateUserTrait, UpdateUserTrait, ChangeUserPasswordTrait;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'first_name' => [
            'searchable' => true,
        ],
        'last_name' => [
            'searchable' => true,
        ],
        'send_notification' => [
            'searchable' => true,
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'first_name',
        'last_name',
        'send_notification',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        /*'send_notification',*/
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'reserved'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'send_notification' => 'boolean',
    ];
}
