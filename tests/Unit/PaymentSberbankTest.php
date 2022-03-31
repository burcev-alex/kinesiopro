<?php

namespace Tests\Unit;

use App\Domains\Order\Models\Order;
use App\Domains\Order\Services\Payment\PaymentFactory;
use Tests\TestCase;

class PaymentSberbankTest extends TestCase
{
    /**
     * @test
     */
    public function get_generation_payment_link_test()
    {
        $service = PaymentFactory::getPaymentMethod('sberbank');

        $order = Order::where('id', rand(1, 10))->get()->first();
        
        $responce = $service->getPayment($order->toArray());

        dump($responce);

        $this->assertIsArray($responce);
    }
}
