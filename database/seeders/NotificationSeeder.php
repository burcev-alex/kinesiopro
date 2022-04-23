<?php
namespace Database\Seeders;

use App\Domains\Online\Models\Online;
use App\Domains\Order\Models\Order;
use App\Domains\User\Models\User;
use App\Notifications\PaymentOnlineCourseNotification;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = $this->faker;

        $users = User::all();
        $users->each(function ($user) use($faker) {

            for($i=1; $i<=rand(5, 8); $i++){
                $online = Online::where('id', rand(1, 10))->first();
                $order = Order::where('id', rand(1, 10))->first();

                Notification::send($user, new PaymentOnlineCourseNotification($online->toArray(), $order->toArray()));
            }
        });
  
        
    }
}
