<?php
namespace Database\Seeders;

use App\Domains\Banner\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<5; $i++){
            Banner::factory()->create();
        }
    }
}
