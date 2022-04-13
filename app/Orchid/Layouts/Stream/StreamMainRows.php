<?php


namespace App\Orchid\Layouts\Stream;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class StreamMainRows extends Rows
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
        $rows = [
            Input::make('stream.title')->title('Название')->required(),
            Input::make('stream.slug')->title('Символьный код')->required(),
            CheckBox::make('stream.active')->title('Активность'),
        ];

        return $rows;
    }
}
