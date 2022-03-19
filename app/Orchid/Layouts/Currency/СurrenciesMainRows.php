<?php


namespace App\Orchid\Layouts\Currency;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class СurrenciesMainRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
       $rows = [];

        $rows = [
            ...$rows,
            ...[
                Input::make('currencies.name')->title('Название')->required(),
                Input::make('currencies.code')->title('Код валюты')->required(),
                Input::make('currencies.value')->title('Курс')->required(),
                CheckBox::make('currencies.active')->title('Активность')
            ]
        ];

        return $rows;
    }
}
