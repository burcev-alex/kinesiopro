<?php
namespace App\Orchid\Layouts\Currency;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CurrenciesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'сurrencies';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('name', 'Название'),
            
            TD::make('active', 'Активность')->render(function($currency){
                return $currency->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('code', 'Символьный код')->render(function($currency){
                return Link::make($currency->code)->route('platform.currencies.edit', $currency);
            })

        ];
    }
}
