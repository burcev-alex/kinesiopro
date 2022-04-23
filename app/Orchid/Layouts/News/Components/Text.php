<?php

namespace App\Orchid\Layouts\News\Components;

use App\Orchid\Layouts\News\NewsPaperComponent;
use App\Orchid\Layouts\News\Interfaces\NewsPaperComponentInterface;
use Orchid\Screen\Fields\Quill;

class Text extends NewsPaperComponent implements NewsPaperComponentInterface
{
    public function render(): array
    {
        return [
            Quill::make($this->prefix . '.text')->value($this->component->fields['text'])->title('Текст')
        ];
    }
}
