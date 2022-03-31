<?php

namespace App\Domains\Order\Models\Traits\Observer;

use App\Domains\Order\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait OrderObserver
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->number = (string) self::generateNumber();
        });
    }

    /**
     * Формирование номера зказа
     *
     * @return string
     */
    private static function generateNumber(){

        // узнать последний сформированный заказа
        $lastOrderId = Order::whereDate('created_at', Carbon::today())->count();

        $result = date('d/m/y').'_'.str_pad($lastOrderId + 1, 3, '0', STR_PAD_LEFT);

        return $result;
    }
}
