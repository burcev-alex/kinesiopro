<?php
namespace App\Orchid\Layouts\News;

use App\Domains\Blog\Models\NewsPaper;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NewsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'news';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', 'Заголовок')->render(function (NewsPaper $item)
            {
                return Link::make($item->title)->route('platform.news.edit', $item->id);
            }),
            TD::make('active', 'Активность')->render(function (NewsPaper $item)
            {
                return CheckBox::make('active')
                ->value($item->active)->disabled();
            }),
            TD::make('slug', 'URL'),
            TD::make('publishDate', 'Дата публикации')->render(function(NewsPaper $item){
                return $item->publishDate;
            })
        ];
    }
}
