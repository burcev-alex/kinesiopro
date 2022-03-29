<?php
namespace Database\Seeders;

use App\Domains\Teacher\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20; $i++){
            Teacher::factory()->create();
        }
    }
}
