<?php
namespace Database\Seeders;

use App\Domains\Course\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<100; $i++){
            Course::factory()->create();
        }
    }
}
