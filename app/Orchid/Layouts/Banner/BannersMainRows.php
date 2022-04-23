<?php


namespace App\Orchid\Layouts\Banner;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;

class BannersMainRows extends Rows
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
                Input::make('banner.name')->title('Название')->required(),
                Input::make('banner.sort')->title('Сортировка')->required(),
                CheckBox::make('banner.active')->title('Активность'),
                Group::make([
                    Label::make('')->value('Огранизационная информация'),
                    Input::make('banner.time_organization')->title('Время организации'),
                    Input::make('banner.place')->title('Место'),
                    Input::make('banner.description')->title('Комментарий'),
                ]),
            ],
        ];

        return $rows;
    }
}
