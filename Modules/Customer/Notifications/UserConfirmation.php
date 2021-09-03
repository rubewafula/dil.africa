<?php

namespace Modules\Customer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserConfirmation extends Notification
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
                    ->line('Thank you for registering at DIL.Africa. We are pleased to '
                            . 'service your orders for your online shopping needs '
                            . 'and with an experience that is unmatched. DIL.Africa '
                            . 'delivers your orders promptly because we understand that '
                            . 'time is important for you. No one else matches our delivery '
                            . 'turnaround time. We are certain that you will truly enjoy our '
                            . 'services.'
                            . 'Please  confirm  your email  by clicking the '
                            . 'button below to activate  your  account')
                    ->action('Activate  Account', 
                            url('shop/confirm_account/'.$this->user->confirmation_token));
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
