<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Upload;

class Gif extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Upload::make($this->prefix . '.media')->value( isset($this->component->mediaFields['media']) ? $this->component->mediaFields['media'][0]->id : [])->title('Гифка')
        ];
    }
}