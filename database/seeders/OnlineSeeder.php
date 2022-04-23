<?php
namespace Database\Seeders;

use App\Domains\Online\Models\Online;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class OnlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<32; $i++){
            Online::factory()->create();
        }
    }
}
