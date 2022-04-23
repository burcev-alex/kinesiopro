<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;

class TitleText extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        return [
            Input::make($this->prefix . '.title')->value($this->component->fields['title'])->title('Заголовок'),
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст'),
        ];
    }
}
