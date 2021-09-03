<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Country;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Area;

class Order extends Model
{
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
    protected $fillable = ['user_id', 'total_value', 'voucher_code', 'voucher_amount', 'order_status', 
        'order_reference', 'user_address_id', 'shipping_cost', 'transaction_cost',
        'notes', 'payment_gateway_id', 'payment_status', 'dispatch_date',
        'rider_id', 'email_address', 'agent_order', 'job_processed',
        'confirmation_token', 'expected_delivery_time', 'return_comments', 'payment_reference'];

    public function user()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User');
    }
    
    public function user_address()
    {
        return $this->BelongsTo('Modules\Customer\Entities\User_address');
    }

    public function rider()
    {
        return $this->BelongsTo('Modules\Customer\Entities\Rider');
    }

    public  function order_details()
     {

        return  $this->HasMany('Modules\Customer\Entities\Order_detail');
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
            $city = City::find($user_address->city_id)->name;
            $country = Country::find($user_address->country_id)->name;
            $address = "<strong>".$delivery_mode.":</strong> ".$user_address->building.", <span style='color:#0F7DC2;'>Floor: </span>".$user_address->floor.', '.$user_address->street.', '.$city.', '.$country;

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