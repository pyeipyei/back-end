<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->line('Here is the reset password code' . $this->code)
            ->line('Thank you for using our application!');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}
