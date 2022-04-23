<?php

namespace App\Orchid\Layouts\Stream\Components;

use App\Orchid\Layouts\Stream\LessonComponent;
use App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;

class TitleText extends LessonComponent implements LessonComponentInterface
{
    public function render(): array
    {
        return [
            Input::make($this->prefix . '.title')->value($this->component->fields['title'])->title('Заголовок'),
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст'),
        ];
    }
}
