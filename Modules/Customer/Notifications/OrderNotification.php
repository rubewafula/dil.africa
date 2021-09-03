<?php

namespace Modules\Customer\Notifications;

use Modules\Customer\Entities\User_address;
use Modules\Customer\Entities\User_pickup_location;
use Modules\Customer\Entities\City;
use Modules\Customer\Entities\Country;
use Modules\Customer\Entities\Warehouse;
use Modules\Customer\Entities\Area;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Session;
use PDF;
use Illuminate\Support\Facades\Log;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    private $order;
    private $user;
    private $cart_items;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $user, $cart_items)
    {
        $this->order = $order;
        $this->user = $user;
        $this->cart_items = $cart_items;
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

      Log::info("Called the mail function ready to send the emails");
        
      $mailMessage = new MailMessage();
      $order = $this->order;

      $pdf = PDF::loadView('modules/customer/checkout/invoice', compact('order'));
      $pdf->setPaper('A4', 'landscape');

      if($this->order->payment_gateway_id == 1){
          
          $mailMessage->greeting('Dear '.$this->user->first_name.',')
                ->subject('Your Order')
                ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
                ->line('Thank you for placing an order with DIL.AFRICA.')->line('Your order '.$this->order->order_reference.' has been placed and is pending confirmation.If we need to confirm any information regarding your purchase, we will call you within 1 hour (calling hours: Mon-Fri 8am - 8pm; Sat-Sun 9am - 3pm) or email you if you are not reachable. If you don\'t respond within 48 hours, we will cancel your order and notify you via email. Please note: If you\'d like to change your order details (e.g recipient, delivery address), please contact us now at 0797 522522 or email us at customercare@dil.africa. You will no longer be able to change them at a later stage. Please Click on the "Confirm Order" button below to confirm your order.')
                ->action('Confirm Order', url('shop/confirm-order/'.$this->order->confirmation_token))
                ->line('</div>');
      }
      else{

         $mailMessage->greeting('Dear '.$this->user->first_name.',')
                ->subject('Your Order')
                ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
                ->line('Thank you for placing an order with DIL.AFRICA!')->line('Your order '.$this->order->order_reference.' has been placed. If we need to confirm any information regarding your purchase, we will call you within 1 hour (calling hours: Mon-Fri 8am - 8pm; Sat-Sun 9am - 3pm) or email you if you are not reachable. If you don\'t respond within 48 hours, we will cancel your order and notify you via email. Please note: If you\'d like to change your order details (e.g recipient, delivery address), please contact us now at 0797 522522 or email us at customercare@dil.africa. You will no longer be able to change them at a later stage.')
                ->action('Check Order', url('shop/track-order'))
                ->line('</div>');
        }

        $order_amount = 0;
        $delivery_selection = Session::get('delivery_type');
        $userId = Session::get('userId'); 
        $delivery_mode = "";
        $drop_location = "";
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

            $order_amount += $cart_item->getSubtotal();
            $cart_table = $cart_table.'<tr><td style="border-bottom:1px solid #eee;">'.$cart_item->getProductName().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getUnitPrice()).'</td><td style="border-bottom:1px solid #eee;">'.$cart_item->getQuantity().'</td><td style="border-bottom:1px solid #eee;">'.number_format($cart_item->getSubtotal()).'</td></tr>';
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

        $mailMessage
            ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
            ->line('<span style="font-weight:bold;color:#0f7dc2;">Your order details are as below:</span><br/>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr><td style="background:#eee;color:#0f7dc2;">Order Reference:</td><td style="border-bottom:1px solid #eee;">'.$this->order->order_reference.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Your Name:</td><td style="border-bottom:1px solid #eee;">'.ucfirst($this->user->first_name).' '.ucfirst($this->user->last_name).'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Email Address:</td><td style="border-bottom:1px solid #eee;">'.$this->user->email.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Phone Number:</td><td style="border-bottom:1px solid #eee;">'.$this->user->phone.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Mode of Delivery:</td><td style="border-bottom:1px solid #eee;">'.$delivery_mode.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Dropping / Delivery Location:</td><td>'.$address.'</td></tr>')
             ->line('</table><br/>')
            ->line('<span style="font-weight:bold;font-size:13px;color:#0f7dc2;">Items Ordered</span>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr style="background:#eee;"><td style="border:1px solid #eee;color:#0f7dc2;">Item</td><td style="border:1px solid #eee;color:#0f7dc2;">Unit Price</td><td style="border:1px solid #eee;color:#0f7dc2;">Quantity</td><td style="border:1px solid #eee;color:#0f7dc2;">Total Price</td></tr>')
            ->line($cart_table)
            ->line('<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Shipping Cost</td><td>'.$shipping_cost.'</td></tr>')
            ->line('<tr style="color:#0f7dc2;font-weight:bold;"><td colspan="3">Transaction Cost</td><td>'.$transaction_cost.'</td></tr>')
            ->line('<tr style="background:#0f7dc2;color:#FFF;"><td colspan="3">Grand Total</td><td>'.number_format($grand_total_cost).'</td></tr>')
            ->line('</table><br/>')
            ->line('We hope that you will enjoy our experience and we thank you once more for shopping with us!')
            ->line('</div><br/><br/>')->attachData($pdf->output(), 'Your Order Ref. '.$order->order_reference.'.pdf');;

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
        return [
            //
        ];
    }
}