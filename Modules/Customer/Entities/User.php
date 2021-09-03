<?php

namespace Modules\Customer\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','email', 'password', 'is_customer', 'is_agent',
        'created_by_agent', 'confirmation_token', 'active', 'profile_path', 'socialmedia_name',
        'real_socialmedia_username', 'cover_path', 'provider',
         'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}