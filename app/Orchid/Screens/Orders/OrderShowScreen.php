<?php

namespace App\Orchid\Screens\Orders;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Code as FieldsCode;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Spatie\SchemaOrg\OrderItem;

class OrderShowScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Просмор заказа';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Просмор заказа';

    /**
     * @var bool
     */
    public $exists = false;

    public $data = [];

    /**
     * Query data.
     *
     * @param Order $item
     * @param OrderItem $products
     *
     * @return array
     */
    public function query(Order $item, OrderItem $products) : array
    {
        $this->exists = $item->exists;

        if ($this->exists) {
            $this->data = $this->getOrder($item->id);

            $this->description = 'Посмотреть заказ';
            $this->name = 'Заказ №'.$this->data['id'];
        }

        return [
            'item' => $this->data
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar() : array
    {
        $list = [];

        $list[] = DropDown::make('Смена статуса')->icon('icon-folder-alt')->list([
            Button::make('Подтвержден')
                ->method('set_'.OrderInterface::STATE_CONFIRMED)
                ->icon('icon-check'),
            ModalToggle::make('Оплачен')
                ->modal(OrderInterface::STATE_PAID.'Modal')
                ->method('set_'.OrderInterface::STATE_PAID)
                ->icon('icon-dollar'),
            ModalToggle::make('Отправлен')
                ->modal(OrderInterface::STATE_SHIPPED.'Modal')
                ->method('set_'.OrderInterface::STATE_SHIPPED)
                ->icon('icon-paper-plane'),
            Button::make('Выполнен')
                ->method('set_'.OrderInterface::STATE_COMPLETED)
                ->icon('icon-like'),
            Button::make('Отменен')
                ->method('set_'.OrderInterface::STATE_CANCELLED)
                ->icon('icon-ban'),
        ]);

        $list[] = Button::make('Удалить')->icon('icon-trash')->method('remove')->canSee($this->exists);

        return $list;
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout() : array
    {
        $address = [];
        if (array_key_exists('city', $this->data['delivery']) && is_array($this->data['delivery']['city']) && array_key_exists('title', $this->data['delivery']['city'])) {
            $address[] = $this->data['delivery']['city']['title'];
        }
        if (array_key_exists('department', $this->data['delivery']) && is_array($this->data['delivery']['city']) && is_array($this->data['delivery']['department']) && array_key_exists('title', $this->data['delivery']['department'])) {
            $address[] = $this->data['delivery']['department']['title'];
        }
        if (array_key_exists('address', $this->data['delivery'])) {
            $address[] = $this->data['delivery']['address'];
        }
        if (array_key_exists('custom_address', $this->data['delivery'])) {
            $address[] = $this->data['delivery']['custom_address'];
        }

        return [
            Layout::modal('payedModal', [
                Layout::rows([
                    Input::make('payment_numer')->title('Номер транзакции')->value(''),
                ]),
            ])->applyButton('Отправить')->closeButton('Закрыть')->title('Изменение статуса заказа на оплачен'),
            Layout::modal('shippedModal', [
                Layout::rows([
                    Input::make('delivery_numer')->title('Номер ТТН')->value(''),
                ]),
            ])->applyButton('Отправить')->closeButton('Закрыть')->title('Изменение статуса заказа на отправлен'),
            Layout::columns([
                Layout::rows([
                    Label::make('number')->title('Номер')->value($this->data['number']),
                    Label::make('state')->title('Статус')->value(Order::getStateTitle($this->data['state'])),
                    Label::make('total')->title('Сумма')->value($this->data['total'].' грн'),
                    Label::make('created_at')->title('Дата создания')->value($this->data['created_at']),
                    Label::make('completed_at')->title('Дата выполнения')->value($this->data['completed_at']),
                ])->title('Основная информация'),
                Layout::rows([
                    Label::make('first_name')->value($this->data['first_name'])->title('Имя'),
                    Label::make('last_name')->value($this->data['last_name'])->title('Фамилия'),
                    Label::make('second_name')->value($this->data['second_name'])->title('Отчество'),
                    Label::make('phone')->value($this->data['phone'])->title('Телефон'),
                    Label::make('email')->value($this->data['email'])->title('Email')
                ])->title('Получатель'),
            ]),
            Layout::columns([
                Layout::rows([
                    Label::make('payment_method')->value($this->data['payment_method'])->title('Способ оплаты'),
                    Label::make('payment_status')->value($this->data['payment_status'])->title('Статус оплаты'),
                    Label::make('payment_status')->value($this->data['total'].' грн')->title('Сумма оплаты'),
                    Label::make('payment_numer')->value(array_key_exists('transactionId', $this->data['payment']) ? $this->data['payment']['transactionId'] : '-')->title('Номер транзакции'),
                ])->title('Оплата'),
                Layout::rows([
                    Label::make('delivery_method')->value($this->data['delivery_method'])->title('Способ доставки'),
                    Label::make('delivery_status')->value($this->data['delivery_status'])->title('Статус доставки'),
                    Label::make('delivery_address')->value(implode(', ', $address))->title('Адрес'),
                    Label::make('delivery_ttn')->value(array_key_exists('transactionId', $this->data['delivery']) ? $this->data['delivery']['transactionId'] : '-')->title('ТТН')
                ])->title('Доставка'),
            ]),
            Layout::view('admin.order.detail.products'),
            Layout::rows([
                Label::make('comment')->title('Комментарий клиента')->value($this->data['comment']),
            ])->title('Доп. информация'),
            Layout::rows([
                FieldsCode::make('code')->language(FieldsCode::MARKUP)->value(print_r($this->data,true)),
            ])->title('System'),
        ];
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Order $item)
    {
        $item->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.orders.list');
    }

    /**
     * @param Order $item
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_paid(Order $item, Request $request)
    {
        $data = $this->getOrder($item->id);
        $arrRequest = $request->toArray();

        $orderId = $item->id;

        $order = Order::find($orderId);
        $order->payment = json_encode(array_merge($data['payment'], ['transactionId' => $arrRequest['payment_numer']]));
        $order->state = OrderInterface::STATE_PAID;
        $order->payment_status = 'Оплачен';
        $order->sync_status = 0;
        $res = $order->save();

        if ($res) {
            Alert::info('Статус успешно изменен!');
        } else {
            Alert::warning('Произошла ошибка');
        }

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_shipped(Order $item, Request $request)
    {
        $data = $this->getOrder($item->id);
        $arrRequest = $request->toArray();

        $orderId = $item->id;

        $order = Order::find($orderId);
        $order->delivery = json_encode(array_merge($data['delivery'], ['transactionId' => $arrRequest['delivery_numer']]));
        $order->state = OrderInterface::STATE_SHIPPED;
        $order->delivery_status = 'Передан в службу доставки';
        $order->sync_status = 0;
        $res = $order->save();

        if ($res) {
            Alert::info('Статус успешно изменен!');
        } else {
            Alert::warning('Произошла ошибка');
        }

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_confirmed(Order $item)
    {
        $this->setState($item->id, OrderInterface::STATE_CONFIRMED);

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_cancelled(Order $item)
    {
        $this->setState($item->id, OrderInterface::STATE_CANCELLED);

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_completed(Order $item)
    {
        $this->setState($item->id, OrderInterface::STATE_COMPLETED);

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_refusal(Order $item)
    {
        $this->setState($item->id, OrderInterface::STATE_REFUSAL);

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_pending(Order $item)
    {
        $this->setState($item->id, OrderInterface::STATE_PENDING);

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function setState($orderId, $state)
    {
        $order = Order::find($orderId);
        $order->state = $state;
        $order->sync_status = 0;
        $res = $order->save();

        if ($res) {
            Alert::info('Статус успешно изменен!');
        } else {
            Alert::warning('Произошла ошибка');
        }
    }

    protected function getOrder($id)
    {
        $itemSource = Order::where('id', $id)->with('items', 'user')->get();

        $data = $itemSource->toArray()[0];

        $data['created_at'] = date('d.m.Y H:i:s', strtotime($data['created_at']));
        $data['completed_at'] = date('d.m.Y H:i:s', strtotime($data['completed_at']));

        foreach ($data['items'] as &$product) {
            $product['article'] = $product['property']['article'];
        }
        unset($product);

        return $data;
    }
}
