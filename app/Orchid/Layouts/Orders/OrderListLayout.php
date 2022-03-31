<?php

namespace App\Orchid\Layouts\Orders;

use App\Domains\Order\Models\Order;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class OrderListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'items';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->render(function (Order $item) {
                    return Link::make($item->id)->route('platform.order.show', $item);
            }),
            
            TD::make('number', 'Номер')->render(function (Order $item) {
				return Link::make($item->number)->route('platform.order.show', $item);
                return $item->number;
            }),
            
            TD::make('total', 'Сумма')->render(function (Order $item) {
                return $item->total. " грн";
            }),
            
            TD::make('state', 'Статус')->render(function (Order $item) {
                return $item->state;
            }),
            
            TD::make('first_name', 'Имя')->render(function (Order $item) {
                return $item->first_name;
            }),
            
            TD::make('last_name', 'Фамилия')->render(function (Order $item) {
                return $item->last_name;
            }),
            
            TD::make('phone', 'Телефон')->render(function (Order $item) {
                return $item->phone;
            }),
        ];
    }
}