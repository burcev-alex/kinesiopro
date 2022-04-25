<?php
namespace App\Domains\Order\Http\Controllers\Web;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Validator;
use Davidnadejdin\LaravelRobokassa\LaravelRobokassaClass as FacadeRobokassa;

class RobokassaControllers extends BaseController
{
    protected $data = [];
    protected Order $order;
    protected FacadeRobokassa $service;

    public function __construct(Request $request)
    {
        $this->data = $input = $request->all();

        $this->service = new FacadeRobokassa();

        if (!array_key_exists('InvId', $input)) {
            return abort('419');
        }
        
        $this->order = Order::where('id', $input['InvId'])->get()->first();
    }

    public function success()
    {
        if ($this->order) {
            //  $this->service->validateResult($this->data, floatval($this->order->total))

            // изменение статуса заказа
            
            $fields = [
                'state' => OrderInterface::STATE_PAID,
                'payment_status' => 'payed',
            ];

            $this->order->update($fields);
            
            /**
             * Array
                (
                    [OutSum] => 1541.00
                    [InvId] => 16
                    [SignatureValue] => a4487f74d53baf3e8dbbb5ad6bb740c5
                    [IsTest] => 1
                    [Culture] => ru
                )
             */
        }

        return view('pages.order.robokassa.success', ['data' => $this->data, 'order' => $this->order]);
    }

    public function payment()
    {
        if ($this->order) {
            // изменение статуса заказа
            $fields = [
                'state' => OrderInterface::STATE_PAID,
                'payment_status' => 'payed',
            ];

            $this->order->update($fields);
        }

        return view('pages.order.robokassa.payment', ['data' => $this->data, 'order' => $this->order]);
    }
    
    public function error()
    {
        if ($this->order) {
            // изменение статуса заказа
        }

        return view('pages.order.robokassa.error', ['data' => $this->data, 'order' => $this->order]);
    }
}
