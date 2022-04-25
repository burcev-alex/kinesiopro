<?php
namespace App\Domains\Order\Services;

use App;
use App\Domains\Order\Jobs\PaymentOnlineCourse;
use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Models\OrdersItem;
use App\Domains\Order\Services\Payment\PaymentFactory;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class CheckoutService.
 */
class CheckoutService extends BaseService
{
    protected PaymentFactory $factoryPayment;

    /**
     * CheckoutService constructor.
     *
     * @param  Order  $order
     */
    public function __construct(Order $order, PaymentFactory $factoryPayment)
    {
        $this->model = $order;
        $this->factoryPayment = $factoryPayment;
    }

    /**
     * Создание заказа
     *
     * @param  array  $data
     *
     * @return array
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): array
    {
        DB::beginTransaction();

        // определить способ оплаты
        try {
            $servicePayment = $this->factoryPayment::getPaymentMethod($data['order']['payment']);
        } catch (\Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this element. Please try again. '. $e->getMessage()));
        }

        try {
            $parameters = $data['order'];
            // посчитать общую стоимость заказа
            $total = $data['product']['price'];
            $totalVariant = 1;

            if ($total == 0) {
                throw new GeneralException('В корзине нет товаров!');
            }

            $userEntity = Auth::user();

            if (! empty($userEntity)) {
                $userId = $userEntity->id;
            } else {
                $userId = 0;
            }

            $order = $this->model::create([
                'state' => OrderInterface::STATE_PENDING,
                'confirmed' => 0,
                'user_id' => array_key_exists('user_id', $parameters) ? $parameters['user_id'] : $userId,
                'confirmation_token' => rand(100000, 100000000),
                'completed_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'items_total' => $totalVariant,
                'total' => $total,

                'first_name' => (! empty($userEntity)) ? $userEntity->firstname : $parameters['name'],
                'last_name' => (! empty($userEntity)) ? $userEntity->surname : $parameters['surname'],
                'phone' => (! empty($userEntity)) ? $userEntity->phone : $parameters['phone'],
                'email' => (! empty($userEntity)) ? $userEntity->email : $parameters['user_email'],
                'comment' => '',
                'payment_method' => $parameters['payment'],
                'payment_status' => 'waiting', // 'В ожидании оплаты',
                'promocode' => $parameters['promocode'],
                'payment' => []
            ]);

            if ($order) {
                $orderId = $order->id;
            } else {
                $orderId = 0;
            }

            // данные по товару
            $product = $data['product'];

            // свойства товара
            $property = [];

            $productId = array_key_exists('id', $product) ? $product['id'] : 0;
            $type = array_key_exists('type', $product) ? $product['type'] : 'online';

            $objProduct = new OrdersItem();
            $objProduct->order_id = $orderId;
            $objProduct->quantity = $product['qty'];
            $objProduct->unit_price = $product['price'];
            $objProduct->total = ($product['price'] * $product['qty']);

            $objProduct->product_id = $productId;
            $objProduct->product_type = $type;
            $objProduct->name = $product['name'];
            $objProduct->property = $property;

            $objProduct->save();

            $parameters['order_number'] = $order->number;
            $parameters['order_id'] = $orderId;
            $parameters['product'] = $data['product'];

            // генерация ссылки на оплату
            $parameters['external'] = $servicePayment->getPayment($order->toArray());

            // сохранить идентификатор платежного запроса
            Order::where('id', $orderId)->update(['payment' => $parameters['external']]);

            // событие проверка наличия оплаты
            // если нее не произвели, оставить уведомление через 3часа
            $job = new PaymentOnlineCourse($order->id);
            $job->delay(now()->addMinutes(60*3));
            dispatch($job);

            session()->forget('coupon');
        } catch (\Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this element. Please try again. '. $e->getMessage()));
        }

        DB::commit();

        return $parameters;
    }
}
