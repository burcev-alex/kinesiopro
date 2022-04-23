<?php
namespace Database\Seeders;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseBlock;
use Illuminate\Database\Seeder;

class CoursesBlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::inRandomOrder()->limit(10);
        $courses->each(function ($course) {

            // по 5 блоков на курс
            $blocks = CourseBlock::factory()->state([
                'course_id' => $course->id,
                'teacher_id' => rand(1, 10)
            ])->count(5)->create();
        });
    }
}
