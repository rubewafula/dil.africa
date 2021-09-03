<?php

namespace App\Notifications;

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
                    ->subject('Please  Confirm  Your  Email')
                    ->line('Thank you for registering at DIL.AFRICA .'
                            . 'Please  confirm  your email  by clicking the '
                            . 'button below to activate  your  account')
                    ->action('Activate  Account', 
                            url('confirm_account/'.$this->user->confirmation_token));
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