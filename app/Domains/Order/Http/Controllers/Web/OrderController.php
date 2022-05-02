<?php

namespace App\Domains\Order\Http\Controllers\Web;

use App\Domains\Online\Models\Online;
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
    public function index(string $type = '')
    {
        $userEntity = Auth::user();
        if (! empty($userEntity)) {
            $userId = $userEntity->id;
        } else {
            $userId = 0;
        }

        $rs = Order::where('user_id', $userId)->orderBy('created_at', 'DESC')->with('items')->get();

        $items = [];
        foreach ($rs as $order) {
            $data = $order->toArray();

            $data['stream'] = [];

            if (strlen($type) > 0) {
                $actual = false;
                foreach ($data['items'] as $item) {
                    if ($item['product_type'] == $type) {
                        $actual = true;

                        // онлайн продукты
                        $online = Online::whereId($item['product_id'])->with('stream')->get()->first();

                        if ($online->stream) {
                            $data['stream'] = $online->stream->toArray();
                        }
                    }
                    if ($item['product_type'] == 'online') {
                        // онлайн продукты
                        $online = Online::whereId($item['product_id'])->get()->first();

                        if ($online && $online->type == $type) {
                            $actual = true;
                        }
                    } elseif ($item['product_type'] == 'course' && $type == 'course') {
                        // очные курсы
                        $actual = true;
                    }
                }

                if (!$actual) {
                    continue;
                }
            }

            $data['created_at'] = $order->created;

            // название статуса
            $data['stateTitle'] = Lang::get('history.filter.state.'.$data['state']);
            $data['stateClass'] = $order->state_class;

            $items[$data['id']] = $data;
        }
        
        if ($type == 'marafon') {
            $typeTitle = 'Марафоны';
        } elseif ($type == 'course') {
            $typeTitle = 'Очные курсы';
        } elseif ($type == 'conference') {
            $typeTitle = 'Конференции';
        } elseif ($type == 'webinar') {
            $typeTitle = 'Вебинары';
        } elseif ($type == 'video') {
            $typeTitle = 'Видеокурсы';
        } else {
            $typeTitle = 'Все покупки';
        }

        return view('pages.order.history', ['typeTitle' => $typeTitle, 'items' => $items]);
    }
}
