<?php
namespace App\Orchid\Layouts\Course;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CourseMarketRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Маркетинговые метки';

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Group::make([
                CheckBox::make('course.marker_new')->title('New'),
                CheckBox::make('course.marker_popular')->title('Главная'),
                CheckBox::make('course.marker_archive')->title('Архив'),
            ]),
            Input::make('course.sort')->title('Сортировка')->required()

        ];
    }
}
