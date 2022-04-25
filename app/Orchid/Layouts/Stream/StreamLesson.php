<?php

namespace App\Orchid\Layouts\Stream;

use App\Domains\Stream\Models\Lesson;
use App\Orchid\Layouts\Stream\Interfaces\StreamLessonInterface;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Rows;

/**
 * StreamLesson
 */
class StreamLesson extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $prefix;
    
    protected $lesson;
    protected $slug;
    protected $stream_id;
    protected $sort;

    protected $defNamespace = 'App\Orchid\Layouts\Stream\Lesson';

    /**
     * Каждый блок должен расширять этот класс и
     * имплиментировать App\Orchid\Layouts\Stream\Interfaces\StreamLessonInterface
     * что бы успешно попасть в метод $this->makeLesson()
     *
     * @param  Lesson $lesson
     * @return void
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
        
        $this->title = $lesson->title;
        $this->slug = $lesson->slug;
        $this->stream_id = $lesson->stream_id;
        $this->sort = $lesson->sort;

        $this->prefix = 'lessons.'. $this->lesson->id;
    }


    public function accordionField()
    {
        return Layout::accordion($this->createComponent());
    }

    /**
     * Get the fields elements to be displayed.
     * Этот метод проигнорирован, т.к. необходимо возвращать аккордеон для
     * каждого компонента, а тут зашит массив.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Пытается создать объект класса из пространиства имен указанного в defNamespace
     * Имя класса транспонируется из kebab-case в CamelCase
     *
     * @return array - поля, указанные в методе render запрашиваемого класса
     */
    public function createComponent(): array
    {
        $slug = 'Content';

        try {
            // Выглядит муторно, но по факту просто камэлкэйсит слаг
            // и конкатенирует ее с пространством имен
            $className = $this->defNamespace . '\\' . implode("", collect(explode('-', $slug))->map(function ($item) {
                return ucfirst($item);
            })->toArray());

            $object = new $className($this->lesson);
            return $this->makeLesson($object);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return [];
    }



    /**
     * Рендерит поля компонента и возвращает с примешанным полем сортировки
     *
     * @param  StreamLessonInterface $lesson
     * @return array
     */
    public function makeLesson(StreamLessonInterface $lesson): array
    {
        $fileds = $lesson->render();
        
        return [
            // название планки аккордеона должно быть уникальным
            'Урок : ' . $this->lesson->title => [
                Layout::rows(
                    array_merge(
                        // прибавляем к полям редактирования необходимое для всех
                        // компонентов поле сортировки
                        [
                            Input::make($this->prefix . '.sort')->type('number')->value($this->sort)->title('Сортировка')
                        ],
                        $fileds
                    )
                )
            ],
        ];
    }
}
