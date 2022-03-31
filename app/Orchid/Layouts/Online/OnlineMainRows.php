<?php
namespace App\Orchid\Layouts\Online;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\DateTimer;

class OnlineMainRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title = 'Основное';
    
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $online = $this->query->get('online');

        return [
            CheckBox::make('online.active')->title('Активность'),
            Input::make('online.title')->title('Название')->required(),
            Input::make('online.slug')->title('URL')->required(),
            
            Input::make('online.price')->title('Цена')->required(),
            Input::make('online.sort')->title('Сортировка')->required(),

            Upload::make('images.attachment_id')->title('Картинка анонса')->value($online->attachment_id)->maxFiles(1),

            Select::make('online.type')
                    ->options([
                        'marafon' => 'Марафон',
                        'course' => 'Курс',
                        'conference' => 'Конференция',
                    ])
                    ->title('Тип')
                    ->required(),
            
            Group::make([
                DateTimer::make('online.start_date')->title('Дата начала'),
                DateTimer::make('online.finish_date')->title('Дата окончания'),
            ]),
        ];
    }
}