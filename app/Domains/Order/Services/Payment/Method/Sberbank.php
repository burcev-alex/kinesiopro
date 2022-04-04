<?php

namespace App\Domains\Order\Services\Payment\Method;

use App;
use App\Domains\Order\Services\SberbankInterface;

class Sberbank implements PaymentInterface
{
    public function getPayment(array $data): array
    {
        $description = 'Заказ №' . $data['number'];

        $sberbank = new SberbankInterface();

        //Подготовка массива с данными об оплате
        $params = [
            'orderNumber'  => $data['number'], // Номер заказа
            'amount' => $data['total'], // Сумма заказа в рублях
            'language' => 'ru', // Локализация
            'description' => $description, // Описание заказа
            'returnUrl' => route('sberbank.success'), // URL сайта в случае успешной оплаты
            'failUrl' => route('sberbank.error'), // URL сайта в случае НЕуспешной оплаты
        ];

        //Получение url для оплаты
        $result = $sberbank->paymentURL($params);

        return [
            'payment_id' => $result['payment_id'],
            'url' => $result['payment_url'],
        ];
    }
}
