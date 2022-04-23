<?php

namespace App\Domains\Crm\Jobs;

use App;
use App\Domains\Online\Models\Online;
use App\Domains\Order\Models\Order;
use App\Domains\User\Models\User;
use App\Notifications\PaymentOnlineCourseNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

/**
 * Проверка оплаты заказа по онлайн курса, и поставить напоминание
 */
class PaymentOnlineCourse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;

    /**
     * Создание нового экземпляра задачи.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Выполнение задачи.
     *
     * @return void
     */
    public function handle()
    {
        if (IntVal($this->orderId) == 0) {
            return true;
        }

        $order = Order::whereId($this->orderId)->with('items')->first();
        $item = $order->items->first();

        if (IntVal($order->user_id) > 0) {
            $user = User::whereId($order->user_id)->first();

            if ($item->product_type == 'online') {
                $online = Online::whereId($item->product_id)->first();

                Notification::send($user, new PaymentOnlineCourseNotification($online->toArray(), $order->toArray()));
            }
        }
    }
}
