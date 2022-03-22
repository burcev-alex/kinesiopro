<?php
namespace App\Orchid\Layouts\Quiz;

use App\Domains\Quiz\Models\Item;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuizesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'quizes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', 'Заголовок')->render(function (Item $item)
            {
                return Link::make($item->title)->route('platform.quiz.edit', $item->id);
            }),
            TD::make('active', 'Активность')->render(function (Item $item)
            {
                return CheckBox::make('active')
                ->value($item->active)->disabled();
            }),
            TD::make('slug', 'URL'),
        ];
    }
}
