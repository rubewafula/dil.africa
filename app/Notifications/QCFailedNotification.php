<?php

namespace App\Notifications;

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

class QCFailedNotification extends Notification
{
    use Queueable;
    
    private $product;
    private $user;
    private $qc_rejected_product;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product, $user, $qc_rejected_product)
    {
        $this->product = $product;
        $this->user = $user;
        $this->qc_rejected_product = $qc_rejected_product;
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

        $mailMessage->greeting('Dear '.$this->user->first_name.',')

            ->subject('Product Listing Quality Failed')
            ->line('<div style="line-height:1.8em;font-family:Open Sans, sans-serif;">')
            ->line('The product listed below that you submitted earlier to us for quality control before publishing has failed in quality. You can see below the comments regarding why it did not pass the approval stage. Please correct and resubmit.<br/>')
            ->line('<span style="font-weight:bold;font-size:13px;color:#0f7dc2;">Comments</span>')
            ->line('<table width="100%" cellpadding="2" cellspacing="0" style="border: 1px solid #eee;"><tr><td style="background:#eee;color:#0f7dc2;">Comment</td></tr>')
            ->line('<tr><td style="border-bottom:1px solid #eee;"> '.ucfirst($this->qc_rejected_product->rejection_comment).'</td></tr>')
            ->line('</table><br/>')
            ->line('</div><br/>')
            ->action('Go to Product', url('seller/product/'.$this->product->slug));

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