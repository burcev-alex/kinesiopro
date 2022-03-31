<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Upload;

class Gif extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Upload::make($this->prefix . '.media')->value( isset($this->component->mediaFields['media']) ? $this->component->mediaFields['media'][0]->id : [])->title('Гифка')
        ];
    }
}