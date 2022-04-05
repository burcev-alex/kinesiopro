<?php

namespace App\Orchid\Layouts\Online\Components;

use App\Orchid\Layouts\Online\Interfaces\OnlineDesciptionComponentInterface;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;

class Lists extends OnlineDesciptionComponent implements OnlineDesciptionComponentInterface
{
    public function render(): array
    {
        $max = 10;

        $title = isset($this->component->fields['title']) ? $this->component->fields['title'] : '';
        $marker = isset($this->component->fields['type']) ? $this->component->fields['type'] : 'circle';

        $list = [
            Input::make($this->prefix . '.title')->value($title)->title('Заголовок'),
            Select::make($this->prefix . '.type')
                ->options([
                    'circle' => 'Круг',
                    'cross' => 'Крест'
                ])
                ->title('Тип метки для элементов списка')
                ->value($marker),
        ];

        $helpText = 'Можно оставить пустым, тогда элемент не отобразится';

        for ($key = 0; $key < $max; $key++) {
            if (isset($this->component->fields['list']) && is_array($this->component->fields['list'])) {
                if (array_key_exists($key, $this->component->fields['list'])) {
                    $item = $this->component->fields['list'][$key];
                } else {
                    $item = '';
                }
                $list[] = TextArea::make($this->prefix . '.list.')
                ->value($item)
                ->title('Элемент списка ' . ($key + 1))
                ->help($helpText);
            } else {
                $list[] = TextArea::make($this->prefix . '.list.')
                ->value('')
                ->title('Элемент списка ' . ($key + 1))
                ->help($helpText);
            }
        }

        return $list;
    }
}
