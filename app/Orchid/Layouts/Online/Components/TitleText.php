<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;

class TitleText extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Input::make($this->prefix . '.title')->value($this->component->fields['title'])->title('Заголовок'),
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
