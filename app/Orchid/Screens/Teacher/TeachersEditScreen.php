<?php


namespace App\Orchid\Screens\Teacher;

use App\Domains\Teacher\Models\Teacher;
use App\Domains\Teacher\Services\TeachersService;
use App\Orchid\Layouts\Teacher\TeacherImagesRows;
use App\Orchid\Layouts\Teacher\TeacherMainRows;
use App\Orchid\Layouts\Teacher\TeacherSeoRows;
use App\Orchid\Layouts\Teacher\TeacherShortRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TeachersEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Преподаватель';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование данных преподавателя';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Teacher $teacher){
        $this->exists = $teacher->exists;
        if ($this->exists) {
            $this->description = 'Редактировать данные преподавателя';
            if ($teacher) {
                $this->name = $teacher->full_name;
            }
            return [
                'teacher' => $teacher
            ];
        }
        else{
            return [
                'teacher' => collect([])
            ];
        }
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->method('save')->icon('save'),

            Button::make('Удалить')
                ->method('remove')->icon('trash')
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
            Layout::tabs([
                'Основное' => [
                    TeacherMainRows::class
                ],
                'Описание' => [
                    TeacherShortRows::class
                ],
                'Изображение' => [
                    TeacherImagesRows::class
                ],
                'SEO' => [
                    TeacherSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Teacher $teacher,
        Request $request,
        TeachersService $service
    ){
        $service->setModel($teacher);
        $validate = $request->validate([
            'teacher.full_name' =>'required',
            'teacher.slug' =>'required',
            'teacher.images' =>'array|min:1|max:1|required',
            'teacher.images.attachment_id' => 'array|min:1|max:1|required',
            'teacher.*' => ''
        ]);
        $service->save($validate);
        $service->saveImages(isset($validate['teacher']['images']) ? $validate['teacher']['images'] : []);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.teachers.edit', $teacher->id);
    }

    /**
     * @param Teacher $teacher
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Teacher $teacher)
    {
        $teacher->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.teachers.list');
    }
}
