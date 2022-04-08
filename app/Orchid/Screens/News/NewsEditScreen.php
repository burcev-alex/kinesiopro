<?php

namespace App\Orchid\Screens\News;

use App\Domains\Blog\Models\Component;
use App\Domains\Blog\Models\NewsPaper;
use App\Domains\Blog\Models\NewsPaperComponent as AppNewsPaperComponent;
use App\Orchid\Layouts\News\NewsPaperComponent;
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

class NewsEditScreen extends Screen
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
    public $description = 'Редактирование новости';
    public $news_paper;
    public $components;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(NewsPaper $news_paper): array
    {
        $this->news_paper = $news_paper;
        $this->components = $news_paper->components;
        $this->name = $news_paper->title;
        return [
            'item' => $news_paper,
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
            ModalToggle::make('Удалить новость')->method('delete')->modal('delete')->icon('trash'),
            ModalToggle::make('Добавить компонент')
                ->modal('addcomponent')
                ->method('addcomponent')
                ->icon('plus-alt'),
            ModalToggle::make('Удалить компонент')
            ->method('deletecomponent')
            ->modal('deletecomponent')
            ->icon('trash')
            ->canSee($this->components->count() > 0),
            Link::make("Посмотреть")
            ->href(config('app.url') . "/blog/" . $this->news_paper->slug)
            ->icon('globe-alt'),
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
            $component = new NewsPaperComponent($item);
            return $component->accordionField();
        })->toArray();

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
                    Input::make('item.me.slug')->title('URL')->value($this->news_paper->slug),
                    DateTimer::make('item.me.publication_date')->title('Дата публикации')->value($this->news_paper->publication_date),
                    Input::make('item.me.title')->title('Заголовок')->value($this->news_paper->title),
                    CheckBox::make('item.me.active')
                    ->value($this->news_paper->active)->title('Активность'),
                ]),
                "Картинки" => Layout::rows([
                    Cropper::make('item.me.attachment_id')->title('Обложка')->value($this->news_paper->attachment_id)->width(363)->height(200)->targetId(),
                    Cropper::make('item.me.detail_attachment_id')
                    ->title('Обложка заголовка')->width(144)->height(144)
                    ->value($this->news_paper->detail_attachment_id)->targetId(),
                ]),
                "SEO" => Layout::rows([
                    TextArea::make('item.me.meta_title')->title('Мета название')->value($this->news_paper->meta_title),
                    TextArea::make('item.me.meta_keywords')->title('Мета ключевые слова')->value($this->news_paper->meta_keywords),
                    TextArea::make('item.me.meta_description')->title('Мета описание')->value($this->news_paper->meta_description),
                ])
            ]),
        ];
    }


    public function save(NewsPaper $news_paper_model, Request $request)
    {
        $news_paper = $request->get('item');
        
        if (! isset($news_paper['me']['active'])) {
            $news_paper_model->active = 0;
        } elseif (isset($news_paper['me']['active'])) {
            $news_paper_model->active = 1;
        }

        $news_paper_model->fill($news_paper['me'])->save();
        
        
        if (isset($news_paper['components'])) {
            $news_paper_model->saveComponents($news_paper['components']);
        }

        Toast::success("Изменения сохранены!");
        return redirect()->route('platform.news.edit', $news_paper_model->id);
    }

    public function addcomponent(Request $request)
    {
        $component = Component::find($request->component);
        $fields = [];
        $item = $request->item['id'];

        foreach ($component->fields as $key => $value) {
            $fields[$value] = ' ';
        }

        AppNewsPaperComponent::create([
            "news_paper_id" => $item,
            "component_id" => $component->id,
            "sort" => 0,
            "fields" => $fields
        ]);

        Toast::success('Вы успешно создали новый компонент - ' . $component->name);
        return redirect()->back();
    }



    public function delete(NewsPaper $news_paper_model)
    {
        $name = $news_paper_model->title;
        $news_paper_model->delete();
        Toast::success('Вы успешно удалили новость - ' . $name);
        return redirect()->route('platform.news.list');
    }


    public function deletecomponent(Request $request)
    {
        $component = AppNewsPaperComponent::find($request->component);
        $component->delete();
        return redirect()->back();
    }
}
