<?php

namespace App\Orchid\Layouts\Stream\Components;

use App\Orchid\Layouts\Stream\Interfaces\LessonComponentInterface;
use App\Orchid\Layouts\Stream\LessonComponent;
use Orchid\Screen\Fields\Input;

class Video extends LessonComponent implements LessonComponentInterface
{
    public function render(): array
    {
        $helpText = 'Ссылка должна быть вида "https://www.youtube.com/embed/abc123"';
        
        return [
            Input::make($this->prefix . '.link')->value($this->component->fields['link'])->title('Ссылка на ютуб')->help($helpText)
        ];
    }
}
