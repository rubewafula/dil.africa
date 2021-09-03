<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','delivery_address', 
    'city_id','country_id','address_type','postal_address',
    'postal_code', 'google_area', 'area_id','default','landmark','telephone'];

    public  function user()
    {

        return $this->BelongsTo('App\User');
    }

    public  function  city()
    {

        return  $this->BelongsTo('App\City');
    }

    public  function  country()
    {
         return $this->BelongsTo('App\Country');

    }

    public function area()
    {
         return  $this->BelongsTo('App\Area');
    }
}
