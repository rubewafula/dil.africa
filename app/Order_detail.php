<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail extends Model
{
    //
        use  SoftDeletes;


    public  $table='order_details';

    public  $primarykey='id';


    public  $fillable=['order_id','product_id','quantity',
    'price','product_price_id','status','offer',
    'shipping_status_id','total_value', 'delivery_status',
     'return_comments'];


    public  function  shipping_status()
    {
        return $this->BelongsTo('App\Shipping_status');
    }


    public  function  product()
    {

      return  $this->BelongsTo('App\Product');

    }


    public  function  order()
    {

    	return  $this->BelongsTo('App\Order');
    }


    public  function  product_price()
    {
    	return  $this->BelongsTo('App\Product_price');
    }


    public function getCommission(){

        $product = Product::findorfail($this->product_id);

        $category_id = $product->category_id;
        $category = Category::findorfail($category_id);

        $commission = 10;

        if($category != null){

            $commission = $category->percent_commission;
        }

        return $commission;

    }
}
