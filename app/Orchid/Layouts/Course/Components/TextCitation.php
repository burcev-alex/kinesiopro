<?php

namespace App\Orchid\Layouts\Course\Components;

use App\Orchid\Layouts\Course\Interfaces\CourseDesciptionComponentInterface;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;

class TextCitation extends CourseDesciptionComponent implements CourseDesciptionComponentInterface
{
    public function render(): array
    {
        $fields = $this->component->fields;
        $autor = array_key_exists('autor', $fields) ? $fields['autor'] : '';
        $text = array_key_exists('text', $fields) ? $fields['text'] : '';

        return [
            Input::make($this->prefix . '.autor')->value($autor)->title('Автор цитаты'),
            Quill::make($this->prefix . '.text')->value($text)->title('Текст')
        ];
    }
}
