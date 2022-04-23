<?php
namespace Database\Factories;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoursePropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseProperty::class;

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
            'ref_char_id' => function ($pp)
            {
                $current = CourseProperty::where('course_id', $pp['course_id'])->get()->only('ref_char_id')->toArray();

                $ref = RefChar::whereNotIn('id', $current)->inRandomOrder()->first();
                return $ref != null ? 
                $ref->id : 
                RefChar::factory()->create()->id;
            },
            'ref_char_value_id' => function ($pp)
            {
                $ref_value = RefCharsValue::where('char_id', $pp['ref_char_id'])->inRandomOrder()->first();

                return $ref_value->id;
            }
            
        ];
    }
}
