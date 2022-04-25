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
     * Exists
     *
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
    public function query(Order $item) : array
    {
        $this->exists = $item->exists;

        if ($this->exists) {
            $this->data = $this->getOrder($item->id);

            $this->description = 'Посмотреть заказ';
            $this->name = 'Заказ №'.$this->data['id'];
        }

        return [
            'item' => $this->data,
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
            ModalToggle::make('Оплачен')
                ->modal(OrderInterface::STATE_PAID.'Modal')
                ->method('set_'.OrderInterface::STATE_PAID)
                ->icon('icon-dollar'),
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

        return [
            Layout::modal('paidModal', [
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
                    Label::make('total')->title('Сумма')->value($this->data['total'].' руб'),
                    Label::make('created_at')->title('Дата создания')->value($this->data['created_at']),
                    Label::make('completed_at')->title('Дата выполнения')->value($this->data['completed_at']),
                ])->title('Основная информация'),
                Layout::rows([
                    Label::make('first_name')->value($this->data['first_name'])->title('Имя'),
                    Label::make('last_name')->value($this->data['last_name'])->title('Фамилия'),
                    Label::make('phone')->value($this->data['phone'])->title('Телефон'),
                    Label::make('email')->value($this->data['email'])->title('Email'),
                ])->title('Покупатель'),
            ]),
            Layout::columns([
                Layout::rows([
                    Label::make('payment_method')->value($this->data['payment_method'])->title('Способ оплаты'),
                    Label::make('payment_status')->value($this->data['payment_status'])->title('Статус оплаты'),
                ])->title('Оплата'),
                Layout::rows([
                    Input::make('payment_link')
                    ->value(array_key_exists('url', $this->data['payment']) ? $this->data['payment']['url'] : '')
                    ->title('Ссылка'),
                ])->title('Метод оплаты'),
            ]),
            Layout::view('platform.order.detail.products'),
            Layout::rows([
                Label::make('comment')->title('Комментарий клиента')->value($this->data['comment']),
            ])->title('Доп. информация'),
        ];
    }

    /**
     * Remove
     *
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
     * Set paid
     *
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
        $order->payment = array_merge($data['payment'], ['transactionId' => $arrRequest['payment_numer']]);
        $order->state = OrderInterface::STATE_PAID;
        $order->payment_status = 'payed';
        $res = $order->save();

        if ($res) {
            Alert::info('Статус успешно изменен!');
        } else {
            Alert::warning('Произошла ошибка');
        }

        return redirect()->route('platform.order.show', $item);
    }

    /**
     * Set Cancel
     *
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
     * Set complete
     *
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
     * Set refusal
     *
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
     * Set pending
     *
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
     * Set State
     *
     * @param Order $item
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function setState($orderId, $state)
    {
        $order = Order::find($orderId);
        $order->state = $state;
        $res = $order->save();

        if ($res) {
            Alert::info('Статус успешно изменен!');
        } else {
            Alert::warning('Произошла ошибка');
        }
    }

    protected function getOrder($id)
    {
        $itemSource = Order::where('id', $id)->with('items', 'user')->get()->first();

        $data = $itemSource->toArray();

        $data['created_at'] = date('d.m.Y H:i:s', strtotime($data['created_at']));
        $data['completed_at'] = date('d.m.Y H:i:s', strtotime($data['completed_at']));

        return $data;
    }
}
