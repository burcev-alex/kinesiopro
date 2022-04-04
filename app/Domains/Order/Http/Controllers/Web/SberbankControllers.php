<?php
namespace App\Domains\Order\Http\Controllers\Web;

use App\Domains\Order\Models\Order;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Validator;
use App\Domains\Order\Services\SberbankInterface;

class SberbankControllers extends BaseController
{
    protected $data = [];
    protected Order $order;
    protected SberbankInterface $service;

    public function __construct(Request $request)
    {
        $this->data = $input = $request->all();

        $this->service = new SberbankInterface();
        
        $this->order = Order::where('id', $input['InvId'])->get()->first();
    }

    public function success(Request $request)
    {
        $res = $this->service->getState($this->data['payment_id']);
        if ($this->order && $res['success']) {
        
            // изменение статуса заказа

        }

        return view('pages.order.sberbank.success', ['data' => $this->data, 'order' => $this->order]);
    }
    
    public function error(Request $request)
    {
        $res = $this->service->getState($this->data['payment_id']);
        if ($this->order && $res['success']) {
        
            // изменение статуса заказа

        }

        return view('pages.order.sberbank.error', ['data' => $this->data, 'order' => $this->order]);
    }
}
