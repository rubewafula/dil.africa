<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller_order extends Model
{
    //

    public  $table='seller_orders';

    public  $primaryKey='id';

    public  $fillable=['seller_id','order_detail_id','order_id','order_reference','order_date','shipping_status','delivery_due_date','order_status','warehouse_id','received_by','shipping_status_id','cancellation_reason_id','rejection_reason_id','warehouse_rejection_reason','quality_issue_id'];


    public function  quality_issue()
    {

        return  $this->BelongsTo('App\Quality_issue');
    }


     public  function  rejection_reason()
     {

        return  $this->BelongsTo('App\Rejection_reason');
     }
          

    public  function  cancellation_reason()
    {

        return  $this->BelongsTo('App\Cancellation_reason');
    }
     


public  function  shipping_status()
{

    return  $this->BelongsTo('App\Shipping_status');
}

    public  function  seller()
    {

    	return  $this->BelongsTo('App\Seller');
    }


    public function  order_detail()
    {

    	return  $this->BelongsTo('App\Order_detail');
    }


    public  function  order()
    {
    	return $this->BelongsTo('App\Order');
    }


    public  function  warehouse()
    {

    	return $this->BelongsTo('App\Warehouse');
    }
}
