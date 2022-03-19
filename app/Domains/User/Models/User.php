<?php

namespace App\Domains\User\Models;

use App\Domains\User\Models\Traits\Attribute\UserAttribute;
use App\Domains\User\Models\Traits\Method\UserMethod;
use App\Domains\User\Models\Traits\Relationship\UserRelationship;
use App\Domains\User\Models\Traits\Scope\UserScope;
use Database\Factories\UserFactory;
use App\Domains\User\Notifications\ResetPasswordNotification;
use App\Domains\User\Notifications\VerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory,
        MustVerifyEmailTrait,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];
}
