<?php

namespace App\Orchid\Screens\Quiz;

use App\Domains\Quiz\Models\Question;
use App\Domains\Quiz\Models\Item;
use App\Domains\Quiz\Models\ItemQuestion;
use Illuminate\Http\Request;
use Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Cropper;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class QuizItemCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новый тест';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Создание новой тест';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
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
                ->icon('save')
            ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                "Основное" => Layout::rows([
                    Input::make('item.me.slug')->title('Символьный код')->value(''),
                    Input::make('item.me.title')->title('Название')->value(''),
                    CheckBox::make('item.me.active')
                    ->value(false)->title('Активность'),
                    Cropper::make('item.me.attachment_id')->title('Обложка')->width(415)->height(200)->targetId(),
                ]),
            ])
        ];
    }


    public function save(Request $request)
    {
        $quiz_item = $request->get('item')['me'];

        if (!isset($quiz_item['slug']) || !isset($quiz_item['title']) || !isset($quiz_item['attachment_id'])) {
            Toast::error("Не все поля заполнены!");
            return redirect()->back();
        }
        
        $check_slug = Item::where('slug', $quiz_item['slug'])->get()->first();
        
        if ($check_slug) {
            Toast::error("URL новости совпадает с уже существующим!");
            return redirect()->back();
        }
        
        $quiz_item_model = new Item($quiz_item);
        
        if (!isset($quiz_item['active'])) {
            $quiz_item_model->active = 0;
        } elseif (isset($quiz_item['active'])) {
            $quiz_item_model->active = 1;
        }
        
        $quiz_item_model->save();

        Toast::success("Тест успешно создана!");
        Toast::success("Добавьте в нее вопросы!");
        return redirect()->route('platform.quiz.edit', $quiz_item_model->id);
    }
}
