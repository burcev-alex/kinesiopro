<?php
namespace Database\Factories;

use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefCharValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RefCharsValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'char_id' => function ()
            {
                return RefChar::factory()->create()->id;
            },
            'value' => function($rcv){
                return $this->faker->sentence(2);
            },
            'slug' => function($rcv){
                return Str::slug($rcv['value']);
            }
        ];
    }
}
