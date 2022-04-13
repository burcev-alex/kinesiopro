<?php

namespace App\Orchid\Layouts\Stream\Components;

use App\Orchid\Layouts\Stream\LessonComponent;
use App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface;
use Orchid\Screen\Fields\Quill;

class Text extends LessonComponent implements LessonComponentInterface
{
    public function render(): array
    {
        return [
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
