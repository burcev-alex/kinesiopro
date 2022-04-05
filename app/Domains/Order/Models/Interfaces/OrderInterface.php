<?php
namespace App\Domains\Order\Models\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface OrderInterface
{

    const STATE_PENDING     = 'pending';    // Принят
    const STATE_PAID        = 'paid';       // Оплачен
    const STATE_CANCELLED   = 'cancelled';  // Отменен
    const STATE_COMPLETED   = 'completed';  // Выполнен
    const STATE_REFUSAL     = 'refusal';    // Отказ
}
