<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Quill;

class Text extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
