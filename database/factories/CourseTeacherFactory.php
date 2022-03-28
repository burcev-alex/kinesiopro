<?php
namespace Database\Factories;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseTeacher;
use App\Domains\Teacher\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseTeacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => function ()
            {
                return Course::factory()->create()->id;
            },
            'teacher_id' => function ()
            {
                return Teacher::inRandomOrder()->first()->id;
            }
        ];
    }
}
