<?php
namespace App\Orchid\Layouts\Online;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class OnlineSeoRows extends Rows
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
        $online = $this->query->get('online');
        $rows = [
            Input::make('online.meta_h1')
                ->title('Meta H1')->value(isset($online) ? $online->meta_h1 : ''),
            Input::make('online.meta_title')
                ->title('Meta Title')->value(isset($online) ? $online->meta_title : ''),
            Input::make('online.meta_keywords')
                ->title('Meta Keywords')->value(isset($online) ? $online->meta_keywords : ''),
            Input::make('online.meta_description')
                ->title('Meta Description')->value(isset($online) ? $online->meta_description : ''),
        ];

        return $rows;
    }
}
