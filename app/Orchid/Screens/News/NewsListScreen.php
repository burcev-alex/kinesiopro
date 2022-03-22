<?php

namespace App\Orchid\Screens\News;

use App\Domains\Blog\Models\NewsPaper;
use App\Orchid\Layouts\News\NewsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class NewsListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Новости';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Список всех новостей';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'news' => NewsPaper::orderBy('created_at')->paginate(10)
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
            Link::make('Создать новость')->icon('icon-plus-alt')->route('platform.news.create')
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
            NewsListLayout::class
        ];
    }
}
