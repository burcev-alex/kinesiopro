<?php

namespace App\Http\Middleware;

use App\Domains\Order\Models\Interfaces\OrderInterface;
use App\Domains\Order\Models\Order;
use App\Domains\Stream\Models\Stream;
use Closure;
use \Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class StreamAccess
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userEntity = Auth::user();
        if (! empty($userEntity)) {
            $userId = $userEntity->id;
        } else {
            $userId = 0;
        }
        

        if($userId > 0 && $userEntity->type == 'customer'){
            $isAccess = false;

            $condition = explode('/', $request->path());
            if(count($condition) > 0 && $condition[0] == 'stream'){
                $steamSlug = $condition[1];

                $rs = Stream::where('slug', $steamSlug)->with('online')->get();
                if($rs->count() > 0){
                    $stream = $rs->first();
                    
                    if($stream->online){
                        $productId = $stream->online->id;

                        // найти заказы, которые были куплены и оплачены
                        $orders = Order::join('orders_items', 'orders_items.order_id', '=', 'orders.id')
                        ->where('orders.user_id', $userId)
                        ->whereIn('state', [OrderInterface::STATE_COMPLETED, OrderInterface::STATE_PAID])
                        ->where('orders_items.product_id', $productId)
                        ->get();
                        
                        foreach($orders as $order){
                            $start = $order->updated_at->format('Y-m-d');
                            $finish = date('Y-m-d', strtotime($start)+(60*60*24*365));

                            $now = date('Y-m-d');

                            if($now >= $start && $now <= $finish){
                                $isAccess = true;
                            }
                        }
                    }
                }
            }

            if (!$isAccess) {
                return Redirect::to(route('stream.single', ['slug' => $stream->slug]), 301);
            }
        }

        return $next($request);
    }
}
