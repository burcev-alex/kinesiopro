<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use App\Domains\User\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Dashboard';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Добро пожаловать в панель управления.';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $totalOrders = Order::where('payment_status', 'payed')->whereNotIn('state', [OrderInterface::STATE_CANCELLED])->sum('total');

        $countPendingOrders = Order::where('payment_status', 'waiting')->whereNotIn('state', [OrderInterface::STATE_CANCELLED])->count();

        $countUser = User::get()->count();

        
        $payCurrentMonth = (int) Order::where('payment_status', 'payed')
            ->whereBetween('completed_at', [date('Y-m').'-01', date('Y-m').'-31'])
            ->whereNotIn('state', [OrderInterface::STATE_CANCELLED])
            ->sum('total');

        $payPrevMonth = (int) Order::where('payment_status', 'payed')
            ->whereBetween('completed_at', [date('Y-m', strtotime('-1 month')).'-01', date('Y-m', strtotime('-1 month')).'-31'])
            ->whereNotIn('state', [OrderInterface::STATE_CANCELLED])
            ->sum('total');

        if($payPrevMonth > 0){
            $percent = (($payCurrentMonth - $payPrevMonth) * 100) / (int) $payPrevMonth;
        }
        else{
            if($payCurrentMonth > 0){
                $percent = 100;
            }
            else{
                $percent = 0;
            }
        }

        return [
            'metrics' => [
                'Продажи, текущий месяц' => ['value' => number_format((int) $payCurrentMonth), 'diff' => round($percent, 2)],
                'Кол-во пользователей' => ['value' => number_format((int) $countUser), 'diff' => 0],
                'Не оплаченные заказы' => ['value' => number_format((int) $countPendingOrders), 'diff' => 0],
                'Общая прибыть' => number_format((int)$totalOrders),
            ],
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Website')
                ->href('/')
                ->icon('globe-alt'),

            Link::make('GitHub')
                ->href('https://github.com/burcev-alex/kinesiopro')
                ->icon('social-github'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::view('dashboard.welcome'),
        ];
    }
}
