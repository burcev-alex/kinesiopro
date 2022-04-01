<?php
namespace App\Domains\Order\Http\Controllers\Web;

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
        
        $this->order = Order::where('id', $input['InvId'])->get()->first();
    }

    public function success(Request $request)
    {
        if ($this->order && $this->service->validateResult($this->data, $this->order->total)) {
        
            // изменение статуса заказа

        }

        return view('pages.order.robokassa.success', ['data' => $this->data, 'order' => $this->order]);
    }

    public function payment(Request $request)
    {
        if ($this->order && $this->service->validateResult($this->data, $this->order->total)) {
        
            // изменение статуса заказа

        }

        return view('pages.order.robokassa.payment', ['data' => $this->data, 'order' => $this->order]);
    }
    
    public function error(Request $request)
    {
        if ($this->order && $this->service->validateResult($this->data, $this->order->total)) {
        
            // изменение статуса заказа

        }

        return view('pages.order.robokassa.error', ['data' => $this->data, 'order' => $this->order]);
    }
}
