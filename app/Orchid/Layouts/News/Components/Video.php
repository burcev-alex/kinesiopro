<?php

namespace App\Orchid\Layouts\News\Components;

use App\Orchid\Layouts\News\Interfaces\NewsPaperComponentInterface;
use App\Orchid\Layouts\News\NewsPaperComponent;
use Orchid\Screen\Fields\Input;

class Video extends NewsPaperComponent implements NewsPaperComponentInterface
{
    public function render(): array
    {
        return [
            Input::make($this->prefix . '.link')->value($this->component->fields['link'])->title('Ссылка на ютуб')->help('Ссылка должна быть вида "https://www.youtube.com/embed/abc123"')
        ];
    }
}