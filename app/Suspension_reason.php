<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspension_reason extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suspension_reasons';

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
    protected $fillable = ['name'];


    public  function  product_suspensions()
    {

        return  $this->HasMany('App\Product_suspension');
    }

    
}
