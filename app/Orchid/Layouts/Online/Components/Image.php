<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Upload;

class Image extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        if (isset($this->component->mediaFields['media']) &&
        count($this->component->mediaFields['media']) > 0) {
            $value = $this->component->mediaFields['media'][0]->id;
        } else {
            $value = [];
        }
        
        return [
            Upload::make($this->prefix . '.media')->value($value)->title('Изображение')->maxFiles(1)
        ];
    }
}
