<?php

namespace App\Orchid\Layouts\News\Components;

use App\Orchid\Layouts\News\NewsPaperComponent;
use App\Orchid\Layouts\News\Interfaces\NewsPaperComponentInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;

class TitleText extends NewsPaperComponent implements NewsPaperComponentInterface
{
    public function render(): array
    {
        return [
            Input::make($this->prefix . '.title')->value($this->component->fields['title'])->title('Заголовок'),
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
