<?php
namespace App\Orchid\Layouts\Course;

use App\Domains\Category\Models\Category;
use App\Domains\Teacher\Models\Teacher;
use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Repository;

class CourseMainRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Основное';
    
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $course = $this->query->get('course');

        // категории
        $arCategoryList = [];
        $categories = Category::get();
        foreach ($categories as $category) {
            $arCategoryList[$category->id] = $category->name;
        }
        
        // Преподаватели
        $arTeacherList = [];
        $teachers = Teacher::get();
        foreach ($teachers as $teacher) {
            $arTeacherList[$teacher->id] = $teacher->full_name;
        }

        $teacherIds = [];
        if (isset($course) && count($course->teachers) > 0) {
            foreach ($course->teachers as $teacher) {
                $teacherIds[] = intval($teacher->id);
            }
        }

        return [
            CheckBox::make('course.active')->title('Активность'),
            Input::make('course.name')->title('Название')->required(),
            Input::make('course.slug')->title('Символьный код')->required(),
            
            Input::make('course.price')->title('Цена')->required(),
            
            Group::make([
                DateTimer::make('course.start_date')->title('Дата начала')
                ->allowInput()->required()->enableTime(),
                DateTimer::make('course.finish_date')
                ->allowInput()->title('Дата окончания')->enableTime(),
            ]),

            Group::make([
                Select::make('course.category_id')
                    ->options($arCategoryList)
                    ->value(isset($course) ? $course->category_id : '')
                    ->title('Категория')
                    ->required(),
            ]),

            Group::make([
                Select::make('teachers.id.')
                    ->options($arTeacherList)
                    ->value($teacherIds)
                    ->multiple()
                    ->title('Преподаватели')
                    ->required(),
            ]),
        ];
    }
}
