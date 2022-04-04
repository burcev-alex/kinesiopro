<?php
namespace Database\Factories;

use App\Domains\Order\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment = [
            'Сбербанк',
            'Robokassa'
        ];

        return [
            'number' => 'S-000' . $this->faker->numberBetween(300, 600),
            'completed_at' => Carbon::now(),
            'items_total' => 1,
            'total' => $this->faker->numberBetween(1500, 3000),
            'state' => Order::STATE_PENDING,
            'email' => $this->faker->email(),
            'first_name' => $this->faker->firstNameMale(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber,
            'payment_method' => $payment[rand(0,1)],
            'user_id' => 1,
            'payment_status' => 'waiting', // waiting OR payed
            'payment' => [
                "transactionId" => $this->faker->swiftBicNumber
            ]
        ];
    }
}
