<?php

namespace App\Orchid\Layouts\Course\Blocks;

use App\Domains\Teacher\Models\Teacher;
use App\Orchid\Layouts\Course\CourseBlock;
use App\Orchid\Layouts\Course\Interfaces\CourseBlockInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;

class Content extends CourseBlock implements CourseBlockInterface
{
    public function render(): array
    {
        $title = $this->block ? $this->block->title : '';
        $start_date = $this->block ? $this->block->start_date : '';
        $finish_date = $this->block ? $this->block->finish_date : '';
        $currentTeacher = $this->block ? $this->block->teacher->id : '';

        // Преподаватели
        $arTeacherList = [];
        $teachers = Teacher::get();
        foreach ($teachers as $teacher) {
            $arTeacherList[$teacher->id] = $teacher->full_name;
        }
        
        return [
            Group::make([
                Input::make($this->prefix . '.title')->value($title)->title('Название')->required(),
                Select::make($this->prefix . '.teacher_id')
                    ->options($arTeacherList)
                    ->value($currentTeacher)
                    ->title('Преподаватель')->required(),
            ]),
            Group::make([
                DateTimer::make($this->prefix . '.start_date')->title('Дата начала')->value($start_date)->required(),
                DateTimer::make($this->prefix . '.finish_date')->title('Дата окончания')->value($finish_date)->required(),
            ]),
        ];
    }
}
