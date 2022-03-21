<?php


namespace App\Orchid\Layouts\Teacher;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class TeacherMainRows extends Rows
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
       $rows = [];

        $rows = [
            ...$rows,
            ...[
                Input::make('teacher.full_name')->title('ФИО')->required(),
                Input::make('teacher.sort')->title('Сортировка')->required(),
                CheckBox::make('teacher.active')->title('Активность')
            ]
        ];

        return $rows;
    }
}
