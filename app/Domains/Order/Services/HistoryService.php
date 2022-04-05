<?php

namespace App\Domains\Order\Services;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HistoryService
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = Order::query();
    }

    /**
     * Get list of items in the order
     *
     * @param int $orderId
     * @return array
     */
    public function getCartFormatItems(int $orderId): array
    {
        $orders = $this->query
            ->with('items', function ($query) {
                return $query->select(['id', 'order_id', 'product_id', 'quantity']);
            })
            ->find($orderId);
        $return = [];
        foreach ($orders->items as $item) {
            $return[$item['product_id']][] = [
                'quantity' => $item['quantity'],
            ];
        }
        return $return;
    }

    /**
     * Фильтрация по пользователю
     *
     * @param int $userId
     * @return $this
     */
    public function setUser(int $userId)
    {
        $this->query->where('user_id', $userId);
        return $this;
    }
}
