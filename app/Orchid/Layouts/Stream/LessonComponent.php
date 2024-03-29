<?php

namespace App\Orchid\Layouts\Stream;

use App\Domains\Stream\Models\LessonComponent as AppLessonComponent;
use App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Layouts\Rows;

/**
 * LessonComponent
 */
class LessonComponent extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = '';
    protected $component;
    protected $prefix;
    protected $defNamespace = 'App\Orchid\Layouts\Stream\Components';

    /**
     * Получает модельку привязанного к новости компонента
     * и рендерит поля для редактирования ее json-полей.
     * Для каждого типа компонента должен быть соответствующий
     * его blade-component-слагу (<x-news.text-title/>) класс в пространстве имен App\Orchid\Layouts\Stream\Components
     * (пример: text-title - App\Orchid\Layouts\Stream\Components\TextTitle).
     *
     * Если класса не будет, то компонент проигнорируется в админ панели
     * и заложится ошибка.
     *
     * Каждый компонент должен расширять этот класс и
     * имплиментировать App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface
     * что бы успешно попасть в метод $this->makeComponent()
     *
     * @param  AppLessonComponent $component
     * @return void
     */
    public function __construct(AppLessonComponent $component)
    {
        $this->component = $component;
        $this->title = $component->name;
        $this->prefix = 'item.components.' . $this->component->slug.'-'.$this->component->id;
    }


    public function accordionField()
    {
        return Layout::accordion($this->createComponent($this->component->slug));
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
     * @param  string $slug
     * @return array - поля, указанные в методе render запрашиваемого класса
     */
    public function createComponent(string $slug): array
    {
        try {
            // Выглядит муторно, но по факту просто камэлкэйсит слаг
            // и конкатенирует ее с пространством имен
            $className = $this->defNamespace . '\\' . implode("", collect(explode('-', $slug))->map(function ($item) {
                return ucfirst($item);
            })->toArray());

            $object = new $className($this->component);
            return $this->makeComponent($object);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return [];
    }



    /**
     * Рендерит поля компонента и возвращает с примешанным полем сортировки
     *
     * @param  LessonComponentInterface $component
     * @return array
     */
    public function makeComponent(LessonComponentInterface $component): array
    {
        $fileds = $component->render();

        $val = $this->component->sort;
        
        return [
            // название планки аккордеона должно быть уникальным
            "Компонент " . $this->component->sort . ' : ' . $this->component->name => [
                Layout::rows(
                    array_merge(
                        // прибавляем к полям редактирования необходимое для всех
                        // компонентов поле сортировки
                        [
                            Input::make($this->prefix . '.sort')->type('number')->value($val)->title('Сортировка')
                        ],
                        $fileds
                    )
                )
            ],
        ];
    }
}
