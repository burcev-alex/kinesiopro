<?php

namespace Tests\Unit;

use App\Domains\Order\Models\Order;
use App\Domains\Order\Services\Payment\PaymentFactory;
use Tests\TestCase;

class PaymentRobokassaTest extends TestCase
{
    /**
     * @test
     */
    public function get_generation_payment_link_test()
    {
        $service = PaymentFactory::getPaymentMethod('robokassa');

        $order = Order::where('id', rand(5, 20))->get()->first();
        
        $responce = $service->getPayment($order->toArray());

        dump($responce);

        $this->assertIsArray($responce);
    }
}
