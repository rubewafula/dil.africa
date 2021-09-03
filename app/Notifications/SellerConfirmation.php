<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SellerConfirmation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public  $user;
    public function __construct($user)
    {
        $this->user= $user;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                   ->greeting('Dear '.$this->user->name.' ,')
                    ->subject('Welcome to DIL.Africa, Open  this  email to  finish  your  registration')
                     ->line('Thank you for registering at DIL.Africa as a seller.'
                            . 'We are pleased to have you on board and we believe that this shall be a fruitful engagement. Please ensure that you read our seller agreement as will be shared carefully. At DIL.Africa, we are obsessed with our customers and we believe in giving an amazing experience to them at all times. We extend this call to you as well for us to grow together. Please  confirm  your email  by clicking the '
                            . 'button below to activate  your  account')
                    ->action('Activate  Account', 
                            url('seller/confirm_account/'.$this->user->confirmation_token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
