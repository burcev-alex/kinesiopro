<?php
namespace Database\Factories;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */ 
    public function definition()
    {
        $date = date('Y-m-d H:i').':00';
        $rand = $this->faker->numberBetween(2, 20);

        $teacherList = [];
        for($i=1; $i<=rand(1, 4); $i++){
            $teacherList[] = rand(1, 10);
        }


        return [
            'slug' => $this->faker->slug(2),
            'sort' => 500,
            'active' => true,
            'name' => implode(' ', $this->faker->words(10)),
            'start_date' => $date,
            'finish_date' => date('Y-m-d H:i', strtotime($date) + (60*60*24*$rand)),
            'category_id' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(5000, 150000),
            'marker_new' => $this->faker->numberBetween(0, 1),
            'marker_popular' => $this->faker->numberBetween(0, 1),
            'marker_archive' => $this->faker->numberBetween(0, 1),
            'teacher_id' => array_unique($teacherList),
        ];
    }
}