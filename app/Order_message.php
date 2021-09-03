<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_messages';

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
    protected $fillable = ['user_id','message','order_id','display_to_customer'];


    public  function  user()
    {

        return  $this->BelongsTo('App\User');
    }

    public  function  order()
    {

        return  $this->BelongsTo('App\Order');
    }

    
}
