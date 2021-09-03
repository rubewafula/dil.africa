<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_suspension extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_suspensions';

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
    protected $fillable = ['product_id','suspension_reason_id','user_id','comments'];


    public  function  product()
    {
        return  $this->BelongsTo('App\Product');
    }


    public  function  user()
    {

        return  $this->BelongsTo('App\User');
    }


    public  function suspension_reason()
    {

        return   $this->BelongsTo('App\Suspension_reason');
    }

    
}
