<?php
namespace App\Domains\Order\Services\Payment\Method;

interface PaymentInterface
{
    // Ссылка на оплату
    public function getPayment(array $data): array;
}
