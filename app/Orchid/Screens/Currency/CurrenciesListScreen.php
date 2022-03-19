<?php


namespace App\Orchid\Screens\Currency;


use App\Domains\Currency\Models\Currency;
use App\Orchid\Layouts\Currency\CurrenciesListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class CurrenciesListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Валюты';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех валют';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'сurrencies' => Currency::orderBy('id', 'ASC')->paginate(12)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.currencies.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CurrenciesListLayout::class
        ];
    }
}
