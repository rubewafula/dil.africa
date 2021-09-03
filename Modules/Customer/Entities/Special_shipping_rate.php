<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Special_shipping_rate extends Model
{
    //
    use  SoftDeletes;


    public  $table='special_shipping_rates';

    public  $primarykey='id';


    public  $fillable=['order_amount', 'amount_charged', 'city_id','category_id','status'];


    public  function  category()
    {
        return $this->BelongsTo('App\Category');
    }


    public  function  city()
    {

      return  $this->BelongsTo('App\City');

    }

}