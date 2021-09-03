<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'areas';

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
    protected $fillable = ['name', 'zone_id', 'city_id'];

    public  function  zone()
    {

        return  $this->BelongsTo('App\Zone');
    }


    public  function city()
    {

        return $this->BelongsTo('App\City');

           }

    
}
