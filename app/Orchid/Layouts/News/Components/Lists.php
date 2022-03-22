<?php

namespace App\Orchid\Layouts\News\Components;

use App\Orchid\Layouts\News\NewsPaperComponent;
use App\Orchid\Layouts\News\Interfaces\NewsPaperComponentInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;

class Lists extends NewsPaperComponent implements NewsPaperComponentInterface
{
    public function render(): array
    {
        $max = 10;
        $list = [];

        for ($key = 0; $key < $max; $key++) {
            if (isset($this->component->fields['list']) && is_array($this->component->fields['list'])) {
                if (array_key_exists($key, $this->component->fields['list'])) {
                    $item = $this->component->fields['list'][$key];
                }
                else{
                    $item = '';
                }
                $list[] = TextArea::make($this->prefix . '.list.')->value($item)->title('Элемент списка ' . ($key + 1))->help('Можно оставить пустым, тогда элемент не отобразится');
            } else {
                $list[] = TextArea::make($this->prefix . '.list.')->value('')->title('Элемент списка ' . ($key + 1))->help('Можно оставить пустым, тогда элемент не отобразится');
            }
        }

        return $list;
    }
}
