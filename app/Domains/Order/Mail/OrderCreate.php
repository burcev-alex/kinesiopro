<?php
namespace App\Domains\Order\Mail;

use App\Domains\Order\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderCreate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The request instance.
     *
     * @var array
     */
    public $data;

    public $orderId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = Order::whereId($this->orderId)->with('items')->first();

        return $this->subject('Заказ '.$order->number.' создан')
                ->from('noreplay@kinesiopro.ru', 'KinesioPRO')
                ->view('emails.order.create')
                ->with([
                    'fullName' => $order->first_name.' '.$order->last_name,
                    'order' => $order
                ]);
    }
}
