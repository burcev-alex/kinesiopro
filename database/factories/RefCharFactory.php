<?php
namespace Database\Factories;

use App\Domains\Course\Models\RefChar;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefCharFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RefChar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => 1,
            'sort' => 100,
            'slug' => $this->faker->slug(2),
            'name' => $this->faker->sentence(2)
        ];
    }
}
