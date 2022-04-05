<?php
namespace App\Orchid\Layouts\Property;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Layouts\Rows;

class CoursePropertyValuesRows extends Rows
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
        // получили список всех ref_char_values
        $values = $this->query->get('values');
        $slug = $this->query->get('slug');
        
        $rows = $values->mapToGroups(function ($item) {
            return [$item['slug'] => $item];
        })->map(function ($item, $slug) {
            // для каждого слага выводим обозначения
            return [
                'value' => $item->first() ? $item->first()->value : "",
                'slug' => $slug
            ];
        })->toArray();

        $fields = [
            'value' => TextArea::make(),
            'slug' => TextArea::make()
        ];
        $columns = [
            'Название' => 'value',
            'Символьный код' => 'slug',
        ];

        return [
            Matrix::make('char_values')->fields($fields)
            ->columns($columns)->value($rows)->maxRows(count($rows))
        ];
    }
}
