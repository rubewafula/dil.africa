<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Special_shipping_rate extends Model
{
    //
        use  SoftDeletes;


    public  $table='special_shipping_rates';

    public  $primarykey='id';


    public  $fillable=['order_amount', 'amount_charged', 'zone_id','item_size_id','status'];


    public  function  item_size()
    {
        return $this->BelongsTo('App\Item_size');
    }


    public  function  zone()
    {

      return  $this->BelongsTo('App\Zone');

    }

}