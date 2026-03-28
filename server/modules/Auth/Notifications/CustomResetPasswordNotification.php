<?php

namespace Modules\Auth\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $frontendUrl = config('app.frontend_url', env('FRONTEND_URL', 'http://night-duty-helper.localhost:3000'));
        $resetUrl = $frontendUrl . '/reset-password/' . $this->token . '?email=' . urlencode($this->email);
        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, no further action is required.');
    }
}
