<?php

namespace App\Orchid\Layouts\Stream\Components;

use App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface;
use App\Orchid\Layouts\Stream\LessonComponent;
use Orchid\Screen\Fields\Upload;

class Image extends LessonComponent implements LessonComponentInterface
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
