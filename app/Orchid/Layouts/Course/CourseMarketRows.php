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
        $course = $this->query->get('course');

        $marker_new = isset($course) && $course->marker_new ? 1 : 0;
        $marker_popular = isset($course) && $course->marker_popular ? 1 : 0;
        $marker_archive = isset($course) && $course->marker_archive ? 1 : 0;

        return [
            Group::make([
                CheckBox::make('markers.marker_new')->value($marker_new)->title('New'),
                CheckBox::make('markers.marker_popular')->value($marker_popular)->title('Главная'),
                CheckBox::make('markers.marker_archive')->value($marker_archive)->title('Архив'),
            ]),
            Input::make('course.sort')->title('Сортировка')->required(),

        ];
    }
}
