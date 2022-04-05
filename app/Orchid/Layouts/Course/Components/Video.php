<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Input;

class Video extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        $helpText = 'Ссылка должна быть вида "https://www.youtube.com/embed/abc123"';
        
        return [
            Input::make($this->prefix . '.link')->value($this->component->fields['link'])->title('Ссылка на ютуб')->help($helpText)
        ];
    }
}
