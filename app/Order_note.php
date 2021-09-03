<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order_note extends Model
{

    public  $table='order_notes';

    public  $primarykey='id';


    public  $fillable=['order_id','note','user_id',
        'seller_order_id'];


    public  function  order()
    {
        return $this->BelongsTo('App\Order');
    }


    public  function  user()
    {

      return  $this->BelongsTo('App\User');

    }


    public  function  seller_order()
    {

    	return  $this->BelongsTo('App\Seller_order');
    }

}