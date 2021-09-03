<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_discount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_discounts';

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
    protected $fillable = ['name','order_id','discount_type_id','value'];


    public function  order()
    {

    	return  $this->BelongsTo('App\Order');
    }


    public  function  discount_type()
    {
    	return  $this->BelongsTo('App\Discount_type');
    }

    
}
