<?php

namespace App\Domains\Order\Http\Controllers\Web;

use App\Domains\Order\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class OrderController
{
    /**
     * Список заказов
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userEntity = Auth::user();
        if (! empty($userEntity)) {
            $userId = $userEntity->id;
        } else {
            $userId = 0;
        }

        $rs = Order::where('user_id', $userId)->orderBy('created_at', 'DESC')->with('items')->paginate(100);

        $items = [];
        foreach ($rs as $order) {
            $data = $order->toArray();

            $data['created_at'] = date('d.m.Y H:i:s', strtotime($data['created_at']));
            $data['completed_at'] = date('d.m.Y H:i:s', strtotime($data['completed_at']));

            // название статуса
            $data['stateTitle'] = Lang::get('history.filter.state.'.$data['state']);

            $items[$data['id']] = $data;
        }

        return view('pages.order.history', ['items' => $items, 'pagination' => $rs->links()]);
    }
}
