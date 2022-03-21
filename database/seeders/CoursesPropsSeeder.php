<?php
namespace Database\Seeders;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseProperty;
use Illuminate\Database\Seeder;

class CoursesPropsSeeder extends Seeder
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

            // по 3 свойста на курс
            $props = CourseProperty::factory()->state([
                'course_id' => $course->id
            ])->count(3)->create();
        });
    }
}
