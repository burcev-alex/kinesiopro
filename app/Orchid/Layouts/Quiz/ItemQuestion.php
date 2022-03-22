<?php

namespace App\Orchid\Layouts\Quiz;

use App\Domains\Quiz\Models\ItemQuestion as AppItemQuestion;
use App\Orchid\Layouts\Quiz\Interfaces\ItemQuestionInterface;
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
 * ItemQuestion
 */
class ItemQuestion extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = '';
    protected $question;
    protected $prefix;
    protected $defNamespace = 'App\Orchid\Layouts\Quiz\Questions';

    /**
     * Получает модельку привязанного к новости вопроса 
     * и рендерит поля для редактирования ее json-полей. 
     * Для каждого типа вопроса должен быть соответствующий 
     * его blade-question-слагу (<x-news.text-title/>) класс в пространстве имен App\Orchid\Layouts\Quiz\Qestions
     * (пример: text-title - App\Orchid\Layouts\Quiz\Qestions\TextTitle).
     * 
     * Если класса не будет, то вопрос проигнорируется в админ панели
     * и заложится ошибка.
     * 
     * Каждый вопрос должен расширять этот класс и 
     * имплиментировать App\Orchid\Layouts\Quiz\Interfaces\ItemQuestionInterface 
     * что бы успешно попасть в метод $this->makeQuestion()
     *
     * @param  AppItemQuestion $question
     * @return void
     */
    public function __construct(AppItemQuestion $question)
    {
        $this->question = $question;
        $this->title = $question->name;
        $this->prefix = 'item.questions.' . $this->question->slug.'-'.$this->question->id;
    }


    public function accordionField()
    {
        return Layout::accordion($this->createQuestion($this->question->slug));
    }

    /**
     * Get the fields elements to be displayed.
     * Этот метод проигнорирован, т.к. необходимо возвращать аккордеон для 
     * каждого вопроса, а тут зашит массив.
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
    public function createQuestion(string $slug): array
    {
        try {
            // Выглядит муторно, но по факту просто камэлкэйсит слаг 
            // и конкатенирует ее с пространством имен
            $className = $this->defNamespace . '\\' . implode("", collect(explode('-', $slug))->map(function ($item) {
                return ucfirst($item);
            })->toArray());

            $object = new $className($this->question);
            return $this->makeQuestion($object);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
        return [];
    }



    /**
     * Рендерит поля вопроса и возвращает с примешанным полем сортировки
     *
     * @param  ItemQuestionInterface $question
     * @return array
     */
    public function makeQuestion(ItemQuestionInterface $question): array
    {
        $fileds = $question->render();

        return [
            // название планки аккордеона должно быть уникальным
            "Вопрос " . $this->question->sort . ' : ' . $this->question->name => [
                Layout::rows(
                    array_merge(
                        // прибавляем к полям редактирования необходимое для всех 
                        // вопросов поле сортировки
                        [
                            Input::make($this->prefix . '.sort')->type('number')->value($this->question->sort)->title('Сортировка')->size(3)
                        ],

                        $fileds
                    )
                )
            ]
        ];
    }
}
