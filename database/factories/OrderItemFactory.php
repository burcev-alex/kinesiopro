<?php
namespace Database\Factories;

use App\Domains\Online\Models\Online;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Models\OrdersItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrdersItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productId = rand(1, 10);

        return [
            'order_id' => function(){
                return Order::factory()->create()->id;
            },
            'product_id' => function() use($productId) {
                return $productId;
            },
            'product_type' => 'online',
            'quantity' => 1,
            'unit_price' => function($oi){
                return Online::find($oi['product_id'])->price;
            },
            'total' => function($oi){
                return $oi['unit_price'];
            },
            'name' => function($oi){
                return Online::find($oi['product_id'])->title;
            },
            'property' => function($oi){
                $product = Online::find($oi['product_id']);
                
                $arr = $product->first()->toArray();

                return $arr;
            }
        ]; 
    }
}
