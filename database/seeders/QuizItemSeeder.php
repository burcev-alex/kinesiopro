<?php
namespace Database\Seeders;

use App\Domains\Quiz\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class QuizItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10; $i++){
            Item::factory()->create();
        }
    }
}
