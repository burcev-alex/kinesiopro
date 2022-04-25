<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('user.type')
                ->required()
                ->options([
                    'customer' => 'Клиент',
                    'admin' => 'Администратор'
                ])
                ->title('Тип пользователя'),
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Псевдоним'),

            Input::make('user.firstname')
                ->type('text')
                ->required()
                ->title('Имя'),

            Input::make('user.surname')
                ->type('text')
                ->required()
                ->title('Фамилия'),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('user.phone')
                ->type('text')
                ->required()
                ->title('Телефон'),

            Input::make('user.work')
                ->type('text')
                ->required()
                ->title('Место работы'),

            Input::make('user.position')
                ->type('text')
                ->required()
                ->title('Должность'),

            Input::make('user.country')
                ->type('text')
                ->required()
                ->title('Страна'),
                
            DateTimer::make('user.birthday')->title('Дата рождения'),
            
            Upload::make('user.avatar_id')->title('Аватар')->maxFiles(1),
            Upload::make('user.scan_id')->title('Скан')->maxFiles(1),
        ];
    }
}
