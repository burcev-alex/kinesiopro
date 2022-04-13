<?php


namespace App\Orchid\Screens\Stream;

use App\Domains\Stream\Models\Lesson;
use App\Domains\Stream\Models\Stream;
use App\Domains\Stream\Services\StreamOrchidService;
use App\Orchid\Layouts\Stream\StreamImagesRows;
use App\Orchid\Layouts\Stream\StreamMainRows;
use App\Orchid\Layouts\Stream\StreamSeoRows;
use Orchid\Screen\Fields\Select;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\DropDown;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Stream\StreamLesson;

class StreamEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Видео-курс';
    
    public $lessons;

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование данных видео-курса';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Stream $stream)
    {
        $this->exists = $stream->exists;
        if ($this->exists) {
            $this->description = 'Редактировать данные видео-курса';
            if ($stream) {
                $this->name = $stream->title;
            }
            
            
            $this->lessons = $stream->lessons;

            return [
                'stream' => $stream,
                'lessons' => $stream->lessons,
            ];
        } else {
            return [
                'stream' => collect([]),
                'lessons' => collect([]),
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

            DropDown::make('Уроки')
            ->slug('sub-menu-lesson')
            ->icon('code')
            ->list([
                Button::make('Добавить урок')
                    ->method('addlesson')
                    ->icon('plus-alt'),

                ModalToggle::make('Удалить урок')
                ->method('deletelesson')
                ->modal('deletelesson')->icon('trash')
                ->canSee($this->lessons->count() > 0),
        ]),

            Button::make('Удалить')
                ->method('remove')->icon('trash'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $optionsLesson = [];
        $lessons = $this->lessons->map(function ($item) use (&$optionsLesson) {
            $optionsLesson[$item->id] = "Урок " . $item->sort . " - " . $item->title;
            $block = new StreamLesson($item);
            return $block->accordionField();
        })->toArray();

        return [
            Layout::modal('deletelesson', [
                Layout::rows([
                    Select::make('lesson')->options($optionsLesson)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('remove', [])->title('Подтвердите удаление'),
            Layout::tabs([
                'Уроки' => $lessons,
                'Основное' => [
                    StreamMainRows::class
                ],
                'Изображение' => [
                    StreamImagesRows::class
                ],
                'SEO' => [
                    StreamSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Stream $stream,
        Request $request,
        StreamOrchidService $service
    )
    {
        $service->setModel($stream);
        $validate = $request->validate([
            'stream.title' => 'required',
            'stream.slug' => 'required',
            'stream.attachment_id' => 'required',
            'stream.*' => '',
            'lessons.*' => '',
        ]);
        $service->save($validate['stream']);

        if (array_key_exists('lessons', $validate)) {
            $service->saveLessons($validate['lessons']);
        }

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.stream.edit', $stream->id);
    }

    /**
     * Remove
     *
     * @param Stream $stream
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Stream $stream)
    {
        $stream->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.stream.list');
    }

    public function addlesson(Stream $stream)
    {
        $item = $stream->id;

        Lesson::create([
            "stream_id" => $item,
            "slug" => md5(time()),
            "sort" => 0,
            "title" => 'Example'
        ]);

        Toast::success('Вы успешно создали новый блок');
        return redirect()->back();
    }

    public function deletelesson(Request $request)
    {
        $lesson = Lesson::find($request->lesson);
        $lesson->delete();
        return redirect()->back();
    }
}
