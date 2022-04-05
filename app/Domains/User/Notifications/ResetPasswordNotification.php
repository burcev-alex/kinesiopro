<?php
namespace App\Domains\User\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class ResetPasswordNotification.
 */
class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @return array|string
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $params = [
            'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
        ];

        $title = __('You are receiving this email because we received a password reset request for your account.');
        $message = __('If you did not request a password reset, no further action is required.');

        return (new MailMessage)
            ->subject(__('Reset Password Notification'))
            ->line($title)
            ->action(__('Reset Password'), route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
                ]))
            ->line(__('This password reset link will expire in :count minutes.', $params))
            ->line($message);
    }
}
