<?php
namespace App\Orchid\Layouts\Teacher;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TeacherListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'teachers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),

            TD::make('image', 'Фото')->render(function ($teacher) {
                return view('platform.teacher-image', [
                    'teacher_name' => $teacher->full_name,
                    'image' => isset($teacher->attachment) ? $teacher->attachment->url() : '',
                    'link' => route('platform.teachers.edit', ['teachers' => $teacher->id])
                ]);
            }),
            
            TD::make('active', 'Активность')->render(function ($teacher) {
                return $teacher->active ? 'да' : '<b>нет</b>';
            }),
        ];
    }
}
