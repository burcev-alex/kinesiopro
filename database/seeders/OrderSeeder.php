<?php
namespace Database\Seeders;

use App\Domains\Order\Models\OrdersItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<50; $i++){
            OrdersItem::factory()->create();
        }
    }
}
