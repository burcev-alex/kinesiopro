<?php
namespace App\Domains\Order\Services\Payment\Method;

class Unknown implements PaymentInterface
{
    // Ссылка на оплату
    public function getPayment(array $data): array {
        return [];
    }
}
