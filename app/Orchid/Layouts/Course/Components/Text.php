<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Quill;

class Text extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
