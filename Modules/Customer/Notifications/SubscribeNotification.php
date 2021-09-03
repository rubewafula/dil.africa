<?php

namespace Modules\Customer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscribeNotification extends Notification
{
    use Queueable;
    
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
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
        
          
          return (new MailMessage)
                ->greeting('Dear Sir / Madam,')
                ->subject('DIL.AFRICA Subscription')
                ->line('Thank you for subscribing at DIL.AFRICA. DIL.AFRICA is committed to making your online shopping experience simple and convinient while bringing on board unmatched prices for our various products spanning across different categories including electronics, mobile phones, hair products, beauty products, fashion, books as well as sports items. We provide verified products and guarantee you warranty on our products to ensure that your rights as a consumer are well protected. We are delighted to have you on board and we believe that you will find our engagement worthwhile.') ;
      
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