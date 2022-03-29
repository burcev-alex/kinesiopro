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
        $date = date('Y-m-d').'10:00:00';
        $rand = $this->faker->numberBetween(2, 20);

        $descr = '';
        for($i=1; $i<20; $i++){
            $descr .= $this->faker->text()." ".$this->faker->text();
        }

        return [
            'slug' => $this->faker->slug(2),
            'sort' => 500,
            'active' => true,
            'name' => implode(' ', $this->faker->words(10)),
            'start_date' => $date,
            'finish_date' => date('Y-m-d', strtotime($date) + (60*60*24*$rand)).' 17:00:00',
            'category_id' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(5000, 150000),
            'marker_new' => $this->faker->numberBetween(0, 1),
            'marker_popular' => $this->faker->numberBetween(0, 1),
            'marker_archive' => $this->faker->numberBetween(0, 1),
            'description' => $descr,
            'meta_h1' => $this->faker->sentence(2),
            'meta_title' => $this->faker->sentence(2),
            'meta_keywords' => implode(' ', $this->faker->words(6)),
            'meta_description' => $this->faker->sentence(),
        ];
    }
}