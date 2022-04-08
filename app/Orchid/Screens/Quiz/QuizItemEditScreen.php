<?php

namespace App\Orchid\Screens\Quiz;

use App\Domains\Quiz\Models\Question;
use App\Domains\Quiz\Models\Item;
use App\Domains\Quiz\Models\ItemQuestion as AppItemQuestion;
use App\Orchid\Layouts\Quiz\ItemQuestion;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class QuizItemEditScreen extends Screen
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
    public $description = 'Редактирование теста';
    public $quiz_item;
    public $questions;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Item $quiz_item): array
    {
        $this->quiz_item = $quiz_item;
        $this->questions = $quiz_item->questions;
        $this->name = $quiz_item->title;
        return [
            'item' => $quiz_item,
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
            ModalToggle::make('Удалить тест')->method('delete')
            ->modal('delete')->icon('trash'),
            ModalToggle::make('Добавить вопрос')
                ->modal('addquestion')
                ->method('addquestion')
                ->icon('plus-alt'),
            ModalToggle::make('Удалить вопрос')
            ->method('deletequestion')
            ->modal('deletequestion')->icon('trash')
            ->canSee($this->questions->count() > 0),
            Link::make("Посмотреть")->href(config('app.url') . "/tests/" . $this->quiz_item->slug)->icon('globe-alt'),
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
        $questions = $this->questions->map(function ($item) use (&$options) {
            $options[$item->id] = "Вопрос " . $item->sort . " - " . $item->question->name;
            $question = new ItemQuestion($item);
            return $question->accordionField();
        })->toArray();

        return [
            Layout::modal('addquestion', [
                Layout::rows([
                    Select::make('question')->fromModel(Question::class, 'name')->value([]),
                    Input::make('item.id')->hidden(),
                ])

            ])->title('Выберите вопрос'),
            Layout::modal('deletequestion', [
                Layout::rows([
                    Select::make('question')->options($options)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('delete', [])->title('Подтвердите удаление'),
            Layout::tabs([
                "Вопросы" => $questions,
                "Основное" => Layout::rows([
                    Input::make('item.me.slug')->title('URL')->value($this->quiz_item->slug),
                    Input::make('item.me.title')->title('Название')->value($this->quiz_item->title),
                    CheckBox::make('item.me.active')
                    ->value($this->quiz_item->active)->title('Активность'),
                    Cropper::make('item.me.attachment_id')->value($this->quiz_item->attachment_id)->title('Обложка')->width(415)->height(200)->targetId(),
                    Cropper::make('item.me.detail_attachment_id')->value($this->quiz_item->detail_attachment_id)->title('Детальная картинка')->width(413)->height(200)->targetId(),
                    Quill::make('item.me.preview')
                    ->value($this->quiz_item->preview)
                    ->title('Анонс'),
                    Quill::make('item.me.description')->value($this->quiz_item->preview)->title('Детальное описание'),
                ]),
                "SEO" => Layout::rows([
                    TextArea::make('item.me.meta_title')->title('Мета название')->value($this->quiz_item->meta_title),
                    TextArea::make('item.me.meta_description')->title('Мета описание')->value($this->quiz_item->meta_description),
                ])
            ]),
        ];
    }

    public function save(Item $quiz_item_model, Request $request)
    {
        $quiz_item = $request->get('item');
        
        if (! isset($quiz_item['me']['active'])) {
            $quiz_item_model->active = 0;
        } elseif (isset($quiz_item['me']['active'])) {
            $quiz_item_model->active = 1;
        }

        if (is_array($quiz_item['me']['attachment_id']) && count($quiz_item['me']['attachment_id']) > 0) {
            $quiz_item['me']['attachment_id'] = current($quiz_item['me']['attachment_id']);
        }

        if (is_array($quiz_item['me']['detail_attachment_id']) && count($quiz_item['me']['detail_attachment_id']) > 0) {
            $quiz_item['me']['detail_attachment_id'] = current($quiz_item['me']['detail_attachment_id']);
        }

        $quiz_item_model->fill($quiz_item['me'])->save();
        
        
        if (isset($quiz_item['questions'])) {
            $quiz_item_model->saveQuestions($quiz_item['questions']);
        }

        Toast::success("Изменения сохранены!");
        return redirect()->route('platform.quiz.edit', $quiz_item_model->id);
    }

    public function addquestion(Request $request)
    {
        $question = Question::find($request->question);
        $fields = [];
        $item = $request->item['id'];

        foreach ($question->fields as $key => $value) {
            $fields[$value] = ' ';
        }

        AppItemQuestion::create([
            "item_id" => $item,
            "question_id" => $question->id,
            "sort" => 0,
            "fields" => $fields
        ]);

        Toast::success('Вы успешно создали новый вопрос - ' . $question->name);
        return redirect()->back();
    }



    public function delete(Item $quiz_item_model)
    {
        $name = $quiz_item_model->title;
        $quiz_item_model->delete();
        Toast::success('Вы успешно удалили тест - ' . $name);
        return redirect()->route('platform.quiz.list');
    }


    public function deletequestion(Request $request)
    {
        $question = AppItemQuestion::find($request->question);
        $question->delete();
        return redirect()->back();
    }
}
