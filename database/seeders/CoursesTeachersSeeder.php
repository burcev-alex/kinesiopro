<?php
namespace Database\Seeders;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseTeacher;
use Illuminate\Database\Seeder;

class CoursesTeachersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
        $courses->each(function ($course) {
            $rand = rand(1, 3);
            
            CourseTeacher::factory()->state([
                'course_id' => $course->id
            ])->count($rand)->create();
        });
    }
}
