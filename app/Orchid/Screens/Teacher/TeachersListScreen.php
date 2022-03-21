<?php


namespace App\Orchid\Screens\Teacher;


use App\Domains\Teacher\Models\Teacher;
use App\Orchid\Layouts\Teacher\TeacherListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class TeachersListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Преподаватели';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех преподавателей';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'teachers' => Teacher::orderBy('id', 'ASC')->paginate(12)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.teachers.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            TeacherListLayout::class
        ];
    }
}
