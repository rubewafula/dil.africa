<?php

namespace Modules\Customer\Notifications;

use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Country;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Area;
use Modules\Customer\Entities\Product_price;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Session;

class AdminOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    private $order;
    private $user;
    private $cart_items;
    private $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $cart_items, $user, $customer)
    {
        $this->order = $order;
        $this->user = $user;
        $this->cart_items = $cart_items;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $order_amount = 0;
        $mailMessage = new MailMessage();
        $delivery_selection = Session::get('delivery_type');
        $userId = Session::get('userId');
        $delivery_mode = "";
        $drop_location = "";
        $user_address_id = Session::get('user_address_id');
        $user_address = null;
        $address = "";
        $city = "";
        $country = "";

        if($delivery_selection =='home_office_delivery')
        {
            $delivery_mode = "Home / Office Delivery";
            $user_address = User_address::where('user_id', $userId)
                        ->where('default', 1)->first();

            if($user_address == null) { 
              
              $user_address = User_address::where('user_id', $userId)->first();  
            }
            
            $city = City::find($user_address->city_id)->name;
            $country = Country::find($user_address->country_id)->name;
            $address = $user_address->building.", ".$user_address->floor.', '.$user_address->street.', '.$city.', '.$country;

        }elseif($delivery_selection =='pickup'){
             $delivery_mode = "Pickup";
             $user_address = User_pickup_location::where('user_id',
                        $userId)->where('default', 1)->first();
             $warehouse = Warehouse::find($user_address->warehouse_id);
             $address = $warehouse->name.', '.Area::find($warehouse->area_id)->name; 

        }

        $cart_table = "";
        
        foreach ($this->cart_items as $cart_item){

            $price = Product_price::find($cart_item->getProductPriceId());

            $size = $price->size;
            $color = $price->color;

            if($size == null){

                $size = "Size: N/A";
            }else {

                $size = "Size: ".$size;
            }

            if($color == null){

                $color = "Color: N/A";
            }else {

                $color = "Color: ".$color;
            }

            $order_amount += $cart_item->getSubtotal();
            $cart_table = $cart_table.'<tr><td style="border-bottom:1px solid #eee;">'.$cart_item->getProductName().'</td><td style="border-bottom:1px solid #eee;">'.$size.', '.$color.'</td><td style="border-bottom:1px solid #eee;">'.$cart_item->getSeller().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getUnitPrice()).'</td><td style="border-bottom:1px solid #eee;">'.$cart_item->getQuantity().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getSubtotal()).'</td></tr>';
        }

        $grand_total_cost = $order_amount;

        $shipping_cost = $this->order->shipping_cost;

        if($shipping_cost == 0){

            $shipping_cost = "-";
        }else {

            $grand_total_cost = $order_amount + $shipping_cost;
            $shipping_cost = number_format($shipping_cost);
        }

        $transaction_cost = $this->order->transaction_cost;

        if($transaction_cost == 0){

            $transaction_cost = "-";
        }else {

            $grand_total_cost = $order_amount + $transaction_cost;
            $transaction_cost = number_format($transaction_cost);
        }

        $mailMessage->greeting('Dear Admin,')

            ->subject('Order Placement')
            ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
            ->line('A new order has been placed at <span style="color:#0f7dc2;font-weight:bold;">DIL.AFRICA</span> platform. The order details are as below:<br/>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr><td style="background:#eee;color:#0f7dc2;">Order Reference:</td><td style="border-bottom:1px solid #eee;">'.$this->order->order_reference.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Customer Name:</td><td style="border-bottom:1px solid #eee;">'.ucfirst($this->customer->first_name).' '.ucfirst($this->customer->last_name).'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Email Address:</td><td style="border-bottom:1px solid #eee;">'.$this->customer->email.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Phone Number:</td><td style="border-bottom:1px solid #eee;">'.$this->customer->phone.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Mode of Delivery:</td><td style="border-bottom:1px solid #eee;">'.$delivery_mode.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Dropping / Delivery Location:</td><td>'.$address.'</td></tr>')
             ->line('</table><br/>')
            ->line('<span style="font-weight:bold;font-size:13px;color:#0f7dc2;">Items Ordered</span>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr style="background:#eee;"><td style="border:1px solid #eee;color:#0f7dc2;">Item</td><td style="border:1px solid #eee;color:#0f7dc2;">Seller</td><td style="border:1px solid #eee;color:#0f7dc2;">Variation</td><td style="border:1px solid #eee;color:#0f7dc2;">Unit Price</td><td style="border:1px solid #eee;color:#0f7dc2;">Quantity</td><td style="border:1px solid #eee;color:#0f7dc2;">Total Price</td></tr>')
            ->line($cart_table)
            ->line('<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Shipping Cost</td><td>'.$shipping_cost.'</td></tr>')
            ->line('<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Transaction Cost</td><td>'.$transaction_cost.'</td></tr>')
            ->line('<tr style="background:#0f7dc2;color:#FFF;"><td colspan="3">Grand Total</td><td>'.number_format($grand_total_cost).'</td></tr>')
            ->line('</table><br/>')
            ->line('Please take the necessary actions to ensure a great customer experience for this order. Thank you!')
            ->line('</div><br/><br/>');

            return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}