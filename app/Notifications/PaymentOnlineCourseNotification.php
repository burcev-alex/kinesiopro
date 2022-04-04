<?php

namespace App\Notifications;

use App\Domains\Online\Models\Online;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentOnlineCourseNotification extends Notification
{
    use Queueable;

    private $onlineData;
    private $orderData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($online, $order)
    {
        $this->onlineData = $online;
        $this->orderData = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->line('Оплатить заказ №'.$this->orderData['number'])
                    ->action('Перейти', url('/orders'))
                    ->line($this->onlineData['title']);
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
            'type' => 'online',
            'title' => 'Оплата онлайн курса',
            'online' => $this->onlineData,
            'order' => $this->orderData,
        ];
    }
}
