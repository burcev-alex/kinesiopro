<?php
namespace App\Orchid\Layouts\Course;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class CourseDescriptionRows extends Rows
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
        
        $course = $this->query->get('course');

        $rows = [
            Quill::make('course.description')->title('Описание')
            ->value(isset($course) ? $course->description : '')
        ];

        return $rows;
    }
}
