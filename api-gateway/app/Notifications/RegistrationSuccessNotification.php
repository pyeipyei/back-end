<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RegistrationSuccessNotification extends Notification
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have register an account.')
            ->line('Here is the confirmation code' . $this->code)
            ->line('Thank you for using our application!');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }
}
