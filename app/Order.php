<?php

namespace App;

use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Country;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Area;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use  SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

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
    protected $fillable = ['user_id','total_value','order_status','order_reference',
    'user_address_id','notes','payment_gateway_id','payment_status','dispatch_date',
    'rider_id','email_address','agent_order','shipping_charges','shipping_type_id',
    'shipping_status_id','cancellation_comments','cancellation_reason_id','cancel_date',
    'cancelled_by','quality_comments','validated_by','validated_on','reviewed_by',
      'reviewed_date','warehouse_id', 'return_comments', 'payment_reference'];

      public  function  warehouse()
      {

        return  $this->BelongsTo('App\Warehouse');
      }

    public  function  cancellation_reason()
    {

      return  $this->BelongsTo('App\Cancellation_reason');
    }

   static  function  total_sales($from_date,$to_date)
   {
       $total_value=  SELF::where('created_at','>=',$from_date)->where('created_at','<=',$to_date)->sum('total_value'); 
       return  $total_value;
     
   }

  public  function  shipping_status()
  {

  	return  $this->BelongsTo('App\Shipping_status');
  }

   public  function  shipping_type()
   {

   	return  $this->BelongsTo('App\Shipping_type');
   }

      public  function  user()
      {

        return  $this->BelongsTo('App\User');
      }

      public  function  user_address()
      {
        return  $this->BelongsTo('App\User_address');
      }

      public  function  payment_gateway()
      {
         return  $this->BelongsTo('App\Payment_gateway');

     }

     public  function order_details()
     {

        return  $this->HasMany('App\Order_detail');
     }

     public  function order_notes()
     {

        return  $this->HasMany('App\Order_note');
     }

     public  function seller_orders()
     {

        return  $this->HasMany('App\Seller_order');
     }

     public  function  messages()
     {
      return  $this->HasMany('App\Order_message');
     }

     public  function  discounts()
     {

     	return $this->HasMany('App\Order_discount');
     }

     public function rider()
     {
        return $this->BelongsTo('App\Rider');
     }

     public function getDeliveryAddress(){

        $shipping_type_id =  $this->shipping_type_id;
        $user_address_id =  $this->user_address_id;
        $address = "";

        if($shipping_type_id == 2)
        {
            $delivery_mode = "Home / Office Delivery";
            $user_address = User_address::where('user_id', $this->user_id)
                        ->where('default', 1)->first();

            if($user_address != null){
              $city = City::find($user_address->city_id)->name;
              $country = Country::find($user_address->country_id)->name;
              $building = $user_address->building;
              $floor = $user_address->floor;
              $street = $user_address->street;
            }else {

              $city = "Unknown";
              $country = "Unknown";
              $building = "Unknown";
              $floor = "Unknown";
              $street = "Unknown";
            }
            $address = "<strong>".$delivery_mode.":</strong> ".$building.", <span style='color:#0F7DC2;'>Floor: </span>".$floor.', '.$street.', '.$city.', '.$country;

        }elseif($shipping_type_id == 1){
             
             $delivery_mode = "Pickup";
             $user_address = User_pickup_location::where('user_id',
                        $this->user_id)->where('default', 1)->first();
             $warehouse = Warehouse::find($user_address->warehouse_id);
             $address = "<strong>".$delivery_mode.":</strong> ".$warehouse->name.', '.Area::find($warehouse->area_id)->name; 
        }

        return $address;
    }


    public function getItemsOrdered(){

        $items_ordered = "";
        $count = 0;

        $order_details = Order_detail::where('order_id', $this->id)->get();
        foreach ($order_details as $detail) {
          $count++;
          $items_ordered = $items_ordered .$count.".<span style='padding-left:10px;'>". $detail->product->name.", <strong>Quantity </strong>".$detail->quantity."</span><br/>";
        }

        return $items_ordered;
    }

}