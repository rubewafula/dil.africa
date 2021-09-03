<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'received_orders';

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
    protected $fillable = ['order_id','seller_order_id','warehouse_id','quantity','order_detail_id','received_by','product_id'] ;


     public  function  product()
     {

        return  $this->BelongsTo('App\Product')->OrderBy('id','DESC');
     }

    public  function  order()
    {
        return  $this->BelongsTo('App\Order');
    }

    public  function  seller_order()
    {

        return  $this->BelongsTo('App\Seller_order');
    }

    public  function  warehouse()
    {
        return  $this->BelongsTo('App\Warehouse');
    }

    public  function  order_detail()
    {

        return  $this->BelongsTo('App\Order_detail')->OrderBy('id','DESC');
    }

    
}
