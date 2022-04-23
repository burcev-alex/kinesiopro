<?php
namespace App\Domains\User\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class VerifyEmail.
 */
class VerifyEmail extends Notification
{
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
        return (new MailMessage)
            ->subject("Вы успешно зарегистрировались на сайте")
            ->line("Спасибо «".$notifiable->name."», Вы успешно зарегистрировались на сайте kinesiopro.ru")
            ->line(__('Login: '). $notifiable->email)
            ->line(__('Password: '). $notifiable->not_code_pass)
            ->line("Пожалуйста, дозаполните свои данные в разделе \"Мои данные\" в Личном кабинете")
            ->line("Удачных покупок! ");
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
