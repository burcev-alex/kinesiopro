<?php
namespace App\Domains\Order\Services\Payment\Method;

use App;
use Davidnadejdin\LaravelRobokassa\LaravelRobokassaClass as FacadeRobokassa;

class Robokassa implements PaymentInterface
{
    public function getPayment(array $data): array
    {
        $description = 'Заказ №'.$data['number'];

        $service = new FacadeRobokassa();

        $payment = $service->createPayment($data['id'], $data['total'], $description);

        return [
            'payment_id' => '',
            'url' => $payment->getPaymentUrl()
        ];
    }
}
