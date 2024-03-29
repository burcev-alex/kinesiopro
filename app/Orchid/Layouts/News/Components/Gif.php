<?php

namespace App\Orchid\Layouts\News\Components;

use App\Orchid\Layouts\News\Interfaces\NewsPaperComponentInterface;
use App\Orchid\Layouts\News\NewsPaperComponent;
use Orchid\Screen\Fields\Upload;

class Gif extends NewsPaperComponent implements NewsPaperComponentInterface
{
    public function render(): array
    {
        $value = isset($this->component->mediaFields['media']) ? $this->component->mediaFields['media'][0]->id : [];
        
        return [
            Upload::make($this->prefix . '.media')->value($value)->title('Гифка')
        ];
    }
}
