<?php
namespace App\Orchid\Screens\Orders;

use App\Domains\Order\Models\Order;
use App\Orchid\Layouts\Orders\OrderListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OrderListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Заказы';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '';

    /**
     * Query data.
     *
     * @return array
     */
    public function query($id): array
    {
        return [
            'items' => Order::orderBy('created_at', 'DESC')->paginate(20)
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            OrderListLayout::class
        ];
    }
}