<?php
namespace App\Domains\Order\Services\Payment;

use App\Domains\Order\Services\Payment\Method\Sberbank;
use App\Domains\Order\Services\Payment\Method\PaymentInterface;
use App\Domains\Order\Services\Payment\Method\Robokassa;
use App\Domains\Order\Services\Payment\Method\Unknown;

/**
 * Class PaymentFactory.
 */
final class PaymentFactory
{
    /**
     * Получаем способ оплаты по его ID.
     *
     * @param $id
     * @return PaymentInterface
     * @throws \Exception
     */
    public static function getPaymentMethod(string $id): PaymentInterface
    {
        switch ($id) {
            case "sberbank":
                return new Sberbank();
            case "robokassa":
                return new Robokassa();
            default:
                return new Unknown();
        }
    }
}
