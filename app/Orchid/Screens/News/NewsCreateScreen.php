<?php

namespace App\Orchid\Screens\News;

use App\Domains\Blog\Models\Component;
use App\Domains\Blog\Models\NewsPaper;
use App\Domains\Blog\Models\NewsPaperComponent;
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

class NewsCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новая новость';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Создание новой новости';

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
                    Input::make('item.me.title')->title('Заголовок')->value(''),
                    CheckBox::make('item.me.active')
                    ->value(false)->title('Активность'),
                    Cropper::make('item.me.attachment_id')->title('Обложка')->width(363)->height(200)->targetId(),
                ]),
            ])
        ];
    }


    public function save(Request $request)
    {
        $news_paper = $request->get('item')['me'];

        if (!isset($news_paper['slug']) || !isset($news_paper['title']) || !isset($news_paper['attachment_id'])) {
            Toast::error("Не все поля заполнены!");
            return redirect()->back();
        }
        
        $news_paper_model = new NewsPaper($news_paper);
        
        if (!isset($news_paper['active'])) {
            $news_paper_model->active = 0;
        } elseif (isset($news_paper['active'])) {
            $news_paper_model->active = 1;
        }
        
        $news_paper_model->save();

        Toast::success("Новость успешно создана!");
        Toast::success("Добавьте в нее компонентов!");
        return redirect()->route('platform.news.edit', $news_paper_model->id);
    }
}
