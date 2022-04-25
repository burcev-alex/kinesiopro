<?php
namespace App\Orchid\Layouts\Online;

use App\Domains\Stream\Models\Stream;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Cropper;
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
        $stream = $this->query->get('stream');

        return [
            CheckBox::make('online.active')->title('Активность'),
            Input::make('online.title')->title('Название')->required(),
            Input::make('online.slug')->title('Символьный код')->required(),
            
            Input::make('online.price')->title('Цена')->required(),
            Input::make('online.sort')->title('Сортировка')->required(),

            Cropper::make('online.attachment_id')->value($online ? $online->attachment_id : '')->title('Картинка анонса')->width(305)->height(305)->targetId(),
            
            Select::make('online.type')
                    ->options([
                        'marafon' => 'Марафон',
                        'course' => 'Курс',
                        'conference' => 'Конференция',
                        'webinar' => 'Вебинар',
                        'video' => 'Видео курс',
                    ])
                    ->title('Тип')
                    ->required(),
            
            Select::make('bind.stream')->fromModel(Stream::class, 'title')->title('Привязка к видеокурсу')->empty()->value(($online && $stream) ? $stream->id : ''),
            
            Group::make([
                DateTimer::make('online.start_date')->title('Дата начала')->enableTime(),
                DateTimer::make('online.finish_date')->title('Дата окончания')->enableTime(),
            ]),
        ];
    }
}
