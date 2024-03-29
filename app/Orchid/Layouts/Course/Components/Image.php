<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Upload;

class Image extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        if ((isset($this->component->mediaFields['media']) &&
            count($this->component->mediaFields['media']) > 0)
            ) {
            $value = $this->component->mediaFields['media'][0]->id;
        } else {
            $value = [];
        }
        
        return [
            Upload::make($this->prefix . '.media')->value($value)->title('Изображение')->maxFiles(1)
        ];
    }
}
