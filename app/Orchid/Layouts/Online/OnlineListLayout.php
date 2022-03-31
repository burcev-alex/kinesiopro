<?php
namespace App\Orchid\Layouts\Online;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OnlineListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'onlines';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', 'Название'),
            
            TD::make('active', 'Активность')->render(function($online){
                return $online->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('code', 'Символьный код')->render(function($online){
                return Link::make($online->slug)->route('platform.online.edit', $online);
            })

        ];
    }
}
