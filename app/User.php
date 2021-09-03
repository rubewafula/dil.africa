<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Inani\Messager\Helpers\MessageAccessible;
use Inani\Messager\Helpers\TagsCreator;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use Messagable;

  //  use MessageAccessible, TagsCreator;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'first_name','last_name','email', 'phone',
       'password','active','confirmation_token',
       'seller_id','is_customer','gender','salutation',
       'dob','is_seller', 'profile_path', 'socialmedia_name',
       'real_socialmedia_username', 'cover_path',
        'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

public  function  notes()
{

  return  $this->HasMany('App\User_note')->OrderBy('id','DESC');
}

public function  getFullnameAttribute()
{

    return  $this->first_name.' '.$this->last_name;
}
public function  getNameAttribute()
{

    return  $this->first_name.' '.$this->last_name;
}

    public  function getStatusAttribute()
    {
        if($this->active == 0)
        {

            return 'INACTIVE';
        }

          if($this->active == 1)
        {

            return 'ACTIVE';
        }

          if($this->active == 2)
        {

            return 'SUSPENDED';
        }

    }


    public  function  seller()
    {

        return  $this->BelongsTo('App\Seller');
    }


    public  function orders()
    {

      return  $this->HasMany('App\Order')->OrderBy('id','DESC');
    }


    public  function  addresses()
    {
      return  $this->HasMany('App\User_address')->OrderBy('id','DESC');
    }
}
