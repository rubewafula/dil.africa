<?php

namespace Modules\Customer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AgentConfirmation extends Notification
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
                   ->greeting('Dear '.$this->user->first_name.' ,')
                    ->subject('Please  Confirm  Your  Account')
                    ->line('Thank you for registering at DIL.Africa as a Sales Agent. We are pleased to '
                            . 'have you on board as one of our sales agent. DIL.Africa provides a great ' 
                            .'opportunity to grow your income by simply assisting customers to place orders ' 
                            .'at out platform. Earn commissions of as high as 20% for each order that you '
                            .'successfully place on behalf of our customers. Welcome and lets grow together!'
                            . 'Please  confirm  your email  by clicking the '
                            . 'button below to activate  your  account')
                    ->action('Activate  Account', 
                            url('shop/agent/confirm_account/'.$this->user->confirmation_token));
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
