<?php
namespace App\Orchid\Layouts\Course;

use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CoursePropsRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $properties = $this->query->get('properties');
        $all_properties = RefChar::get();

        return $all_properties->map(function ($ref) use ($properties) {
            return Select::make('property_values.')
                ->fromQuery(RefCharsValue::where('char_id', $ref->id), 'value', 'id')
                ->multiple()
                ->title($ref->name);
        })
            ->chunk(2)->map(function ($chunk) {
                return Group::make($chunk->toArray());
            })->toArray();
    }
}
