<?php

namespace App\Orchid\Layouts\Course;

use App\Domains\Course\Models\CourseBlock as AppCourseBlock;
use App\Orchid\Layouts\Course\Interfaces\CourseBlockInterface;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Rows;

/**
 * CourseBlock
 */
class CourseBlock extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $prefix;
    
    protected $block;
    protected $defNamespace = 'App\Orchid\Layouts\Course\Blocks';

    /**
     * 
     * Каждый блок должен расширять этот класс и 
     * имплиментировать App\Orchid\Layouts\Course\Interfaces\CourseBlockInterface 
     * что бы успешно попасть в метод $this->makeBlock()
     *
     * @param  AppCourseBlock $block
     * @return void
     */
    public function __construct(AppCourseBlock $block)
    {
        $this->block = $block;
        $this->title = $block->title;
        $this->prefix = 'blocks.'. $this->block->id;
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

            $object = new $className($this->block);
            return $this->makeBlock($object);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return [];
    }



    /**
     * Рендерит поля компонента и возвращает с примешанным полем сортировки
     *
     * @param  CourseBlockInterface $block
     * @return array
     */
    public function makeBlock(CourseBlockInterface $block): array
    {
        $fileds = $block->render();

        return [
            // название планки аккордеона должно быть уникальным
            'Блок : ' . $this->block->title => [
                Layout::rows(
                    array_merge(
                        // прибавляем к полям редактирования необходимое для всех 
                        // компонентов поле сортировки
                        [
                            Input::make($this->prefix . '.sort')->type('number')->value($this->block->sort)->title('Сортировка')
                        ],

                        $fileds
                    )
                )
            ]
        ];
    }
}
