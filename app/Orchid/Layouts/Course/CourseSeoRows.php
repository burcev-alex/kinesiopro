<?php
namespace App\Orchid\Layouts\Course;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;

class CourseSeoRows extends Rows
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
            Input::make('course.meta_h1')
                ->title('Meta H1')->value(isset($course) ? $course->meta_h1 : ''), 
            Input::make('course.meta_title')
                ->title('Meta Title')->value(isset($course) ? $course->meta_title : ''), 
            Input::make('course.meta_keywords')
                ->title('Meta Keywords')->value(isset($course) ? $course->meta_keywords : ''), 
            Input::make('course.meta_description')
                ->title('Meta Description')->value(isset($course) ? $course->meta_description : ''),
        ];

        return $rows;
    }
}
