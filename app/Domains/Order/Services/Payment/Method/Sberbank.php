<?php

namespace App\Domains\Order\Services\Payment\Method;

use App;
use App\Domains\Order\Services\SberbankInterface;

class Sberbank implements PaymentInterface
{
    public function getPayment(array $data): array
    {
        $description = 'Заказ №' . $data['number'];

        // $acquiring_url = 'https://securepayments.sberbank.ru'; // producton
        $acquiring_url = 'https://3dsec.sberbank.ru'; // test
        
        $access_token  = config('kinesio.sberbank.token');

        $sberbank = new SberbankInterface($acquiring_url, $access_token);

        //Подготовка массива с данными об оплате
        $params = [
            'orderNumber'  => $data['number'], // Номер заказа
            'amount' => $data['total'], // Сумма заказа в рублях
            'language' => 'ru', // Локализация
            'description' => $description, // Описание заказа
            'returnUrl' => 'http://localhost/successful-payment', // URL сайта в случае успешной оплаты
            'failUrl' => 'http://localhost/fail-payment', // URL сайта в случае НЕуспешной оплаты
        ];

        //Получение url для оплаты
        $result = $sberbank->paymentURL($params);
        dd($result);

        return [
            'payment_id' => $result['payment_id'],
            'url' => $result['payment_url'],
        ];
    }
}
