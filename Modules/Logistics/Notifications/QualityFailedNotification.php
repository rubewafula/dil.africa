<?php

namespace Modules\Logistics\Notifications;

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

class QualityFailedNotification extends Notification
{
    use Queueable;
    
    private $seller_order;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($seller_order, $user)
    {
        $this->seller_order = $seller_order;
        $this->user = $user;
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

        $mailMessage = new MailMessage();
        $userId = Session::get('userId');

        $cart_table = "";

        $cart_table = $cart_table.'<tr><td style="border-bottom:1px solid #eee;">'.$this->seller_order->order_detail->product->name.'</td><td style="border-bottom:1px solid #eee;">'.$this->seller_order->order_detail->quantity.'</td><td style="border-bottom:1px solid #eee;">'.$this->seller_order->order_detail->price.'</td></tr>';

        $mailMessage->greeting('Dear '.$this->user->first_name.',')

            ->subject('Order Quality Failed')
            ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
            ->line('The quality of your order delivered to <span style="color:#0f7dc2;font-weight:bold;">DIL.AFRICA</span> has been checked and has failed our standards! The details of the order you delivered are as below:<br/>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr><td style="background:#eee;color:#0f7dc2;">Order Reference:</td><td style="border-bottom:1px solid #eee;">'.$this->seller_order->order_reference.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Name:</td><td style="border-bottom:1px solid #eee;"> '.ucfirst($this->seller_order->seller->name).'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Email Address:</td><td style="border-bottom:1px solid #eee;">'.$this->seller_order->seller->email_address.'</td></tr>')
            ->line('<tr><td style="background:#eee;color:#0f7dc2;border:1px solid #eee;">Phone Number:</td><td style="border-bottom:1px solid #eee;">'.$this->seller_order->seller->telephone.'</td></tr>')
             ->line('</table><br/>')
            ->line('<span style="font-weight:bold;font-size:13px;color:#0f7dc2;">Items Delivered</span>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr style="background:#eee;"><td style="border:1px solid #eee;color:#0f7dc2;">Item</td><td style="border:1px solid #eee;color:#0f7dc2;">Unit Price</td><td style="border:1px solid #eee;color:#0f7dc2;">Quantity</td></tr>')
            ->line($cart_table)
            ->line('</table><br/>')
            ->line('Our customer service representative will get in touch with to discuss further on this. <br/><br/>Thank you!')
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