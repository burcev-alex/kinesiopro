<?php
namespace Database\Factories;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseBlock;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use App\Domains\Teacher\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseBlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseBlock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startDate = $this->faker->date();
        $rand = rand(2, 4);

        return [
            'course_id' => function ()
            {
                return Course::factory()->create()->id;
            },
            'teacher_id' => function ()
            {
                return Teacher::factory()->create()->id;
            },
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'sort' => rand(100, 500),
            "start_date" => $startDate,
            "finish_date" => date('Y-m-d', strtotime($startDate) + (60*60*24*$rand)),
        ];
    }
}