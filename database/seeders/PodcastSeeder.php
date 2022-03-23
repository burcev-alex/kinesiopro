<?php
namespace Database\Seeders;

use App\Domains\Podcast\Models\Podcast;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<40; $i++){
            Podcast::factory()->create();
        }
    }
}
