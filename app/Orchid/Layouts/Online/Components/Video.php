<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Input;

class Video extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        $helpText = 'Ссылка должна быть вида "https://www.youtube.com/embed/abc123"';
        
        return [
            Input::make($this->prefix . '.link')->value($this->component->fields['link'])->title('Ссылка на ютуб')->help($helpText)
        ];
    }
}
