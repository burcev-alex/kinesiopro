<?php
namespace App\Domains\Order\Http\Controllers\Web;

use App\Domains\Order\Services\CartService;
use App\Domains\Order\Services\CheckoutService;
use App\Domains\User\Models\User;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CheckoutController extends BaseController
{
    public function success()
    {
        return view('personal.order.checkout_success', []);
    }

    /**
     * Сохранение заказа
     *
     * @param Request $request
     * @param CheckoutService $service
     * @return void
     */
    public function save(Request $request, CheckoutService $service)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'product' => 'required',
            'product.id' => 'required',
            'product.price' => 'required',
            'order' => 'required',
            'order.surname' => 'required|string',
            'order.name' => 'required|string',
            'order.phone' => 'required',
            'order.user_email' => 'required',
            'order.payment' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            $result = $service->store($input);
            if (intval($result['order_id']) > 0) {
                return $this->sendResponse($result, 'Item created successfully.');
            } else {
                throw new GeneralException(__('There was a problem creating this order. Please try again.'));
            }
        } catch (\Exception $e) {
            return $this->sendError('Validation Error.', $e->getMessage());
        }
    }
}
