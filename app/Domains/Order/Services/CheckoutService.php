<?php
namespace App\Domains\Order\Services;

use App;
use App\Domains\Order\Facades\Cart;
use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Models\OrdersItem;
use App\Domains\Order\Services\Payment\PaymentFactory;
use App\Domains\Product\Models\ProductsVariant;
use App\Domains\User\Models\UserProfileDelivery;
use App\Domains\User\Services\RegistratorService;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
     * @return Order
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Order
    {
        DB::beginTransaction();

        // определить способ оплаты
        try {
            $servicePayment = $this->factoryPayment::getPaymentMethod($data['payment']['code']);
        }
        catch (\Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this element. Please try again. '. $e->getMessage()));
        }

        try {
            $parameters = $data['order'];
            // посчитать общую стоимость заказа
            $total = 0;
            $totalVariant = 0;
            foreach ($data['products'] as $product) {
                $total = $total + ($product['price'] * $product['qty']);
                $totalVariant++;
            }

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
                'payment_method' => array_key_exists('payment', $parameters) ? $parameters['payment']['title'] : '',
                'payment_status' => 'waiting', // 'В ожидании оплаты',
                'promocode' => $parameters['promocode'],
                'payment' => [
                    'payment_code' => array_key_exists('payment', $parameters) ? $parameters['payment']['code'] : '-',
                ]
            ]);

            if ($order) {
                $orderId = $order->id;
            } else {
                $orderId = 0;
            }

            foreach ($data['products'] as $product) {
                // свойства товара
                $property = [];

                $productId = array_key_exists('product_id', $product) ? $product['product_id'] : 0;
                $type = array_key_exists('type', $product) ? $product['type'] : 'online';

                $objProduct = new OrdersItem();
                $objProduct->order_id = $orderId;
                $objProduct->quantity = $product['qty'];
                $objProduct->unit_price = $product['price'];
                $objProduct->total = ($product['price'] * $product['qty']);

                $objProduct->product_id = $productId;
                $objProduct->product_type = $type;
                $objProduct->name = $product['title'];
                $objProduct->property = $property;

                $objProduct->save();
            }

            $parameters['order_number'] = $order->number;
            $parameters['order_id'] = $orderId;
            $parameters['products'] = $data['products'];

            // генерация ссылки на оплату
            $parameters['external'] = $servicePayment->getPayment($order->toArray());

            session()->forget('coupon');
        } catch (\Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating this element. Please try again. '. $e->getMessage()));
        }

        DB::commit();

        return $parameters;
    }
}