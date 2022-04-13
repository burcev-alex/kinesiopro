<?php

namespace App\Orchid\Screens\Stream;

use App\Domains\Stream\Models\Component;
use App\Domains\Stream\Models\Lesson;
use App\Domains\Stream\Models\LessonComponent as AppLessonComponent;
use App\Domains\Stream\Models\Stream;
use App\Orchid\Layouts\Stream\LessonComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Log;
use Orchid\Alert\Toast as AlertToast;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class LessonEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = '';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Редактирование урока';
    public $lesson;
    public $stream;
    public $components;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Stream $stream, Lesson $lesson): array
    {
        $this->lesson = $lesson;
        $this->stream = $stream;
        $this->components = $lesson->components;
        $this->name = $lesson->title;
        return [
            'item' => $lesson,
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('save')
                ->method('save')
                ->icon('save'),
            ModalToggle::make('Удалить урок')->method('delete')->modal('delete')->icon('trash'),
            ModalToggle::make('Добавить компонент')
                ->modal('addcomponent')
                ->method('addcomponent')
                ->icon('plus-alt'),
            ModalToggle::make('Удалить компонент')
            ->method('deletecomponent')
            ->modal('deletecomponent')
            ->icon('trash')
            ->canSee($this->components->count() > 0)
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        $options = [];
        $components = $this->components->map(function ($item) use (&$options) {
            $options[$item->id] = "Компонент " . $item->sort . " - " . $item->component->name;
            $component = new LessonComponent($item);
            return $component->accordionField();
        })->toArray();

        array_unshift($components, 
            Layout::rows([
                Link::make('Назад к курсу')
                    ->href(route('platform.stream.edit', ['stream' => $this->lesson->stream_id]))
                    ->icon('undo')
            ])
        );

        return [
            Layout::modal('addcomponent', [
                Layout::rows([
                    Select::make('component')->fromModel(Component::class, 'name')->value([]),
                    Input::make('item.id')->hidden(),
                ])

            ])->title('Выберите компонент'),
            Layout::modal('deletecomponent', [
                Layout::rows([
                    Select::make('component')->options($options)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('delete', [])->title('Подтвердите удаление'),
            Layout::tabs([
                "Компоненты" => $components,
                "Основное" => Layout::rows([
                    Link::make('Назад к курсу')
                    ->href(route('platform.stream.edit', ['stream' => $this->lesson->stream_id]))
                    ->icon('undo'),
                    Input::make('item.me.title')->title('Заголовок')->value($this->lesson->title),
                    Input::make('item.me.sort')->type('number')->value($this->lesson->sort)->title('Сортировка'),
                    Input::make('item.me.slug')->type('hidden')->value($this->lesson->slug),
                    Input::make('item_id')->type('hidden')->value($this->lesson->id),
                    Input::make('stream_id')->type('hidden')->value($this->lesson->stream_id),
                ]),
                "Картинка" => Layout::rows([
                    Cropper::make('item.me.attachment_id')->title('Обложка')->value($this->lesson->attachment_id)->width(305)->height(305)->targetId()
                ])
            ]),
        ];
    }

    public function save(Lesson $lesson_model, Request $request)
    {
        $lesson = $request->get('item');
        $streamId = $request->get('stream_id');
        $id = $request->get('item_id');

        $lesson_model->fill($lesson['me'])->save();
        
        
        if (isset($lesson['components'])) {
            $lesson_model->saveComponents($lesson['components']);
        }

        Toast::success("Изменения сохранены!");

        return redirect()->route('platform.stream.edit.lesson.edit', [
            'stream' => $streamId, 
            'lesson' => $id
        ]);
    }

    public function addcomponent(Request $request)
    {
        $component = Component::find($request->component);
        $fields = [];
        $item = $request->item['id'];

        foreach ($component->fields as $key => $value) {
            $fields[$value] = ' ';
        }

        AppLessonComponent::create([
            "lesson_id" => $item,
            "component_id" => $component->id,
            "sort" => 0,
            "fields" => $fields
        ]);

        Toast::success('Вы успешно создали новый компонент - ' . $component->name);
        return redirect()->back();
    }



    public function delete(Lesson $lesson_model)
    {
        $name = $lesson_model->title;
        $lesson_model->delete();
        Toast::success('Вы успешно удалили урок - ' . $name);
        return redirect()->route('platform.stream.edit', $this->stream);
    }


    public function deletecomponent(Request $request)
    {
        $component = AppLessonComponent::find($request->component);
        $component->delete();
        return redirect()->back();
    }
}
