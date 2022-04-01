<?php

namespace App\Orchid\Layouts\Quiz\Questions;

use App\Orchid\Layouts\Quiz\ItemQuestion;
use App\Orchid\Layouts\Quiz\Interfaces\ItemQuestionInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Group;

class SimpleElement extends ItemQuestion implements ItemQuestionInterface
{
    public function render(): array
    {
        $max = 6;

        $fields = $this->question->fields;
        
        if(array_key_exists('list', $fields) && is_array($fields['list'])){
            $arr = [];
            foreach($fields['list']['answer'] as $key=>$value){
                $arr[] = [
                    'answer' => $value,
                    'point' => $fields['list']['point'][$key]
                ];
            }
            $fields['list'] = $arr;
        }

        $title = array_key_exists('title', $fields) ? $fields['title'] : '';
        
        $list = [
            Input::make($this->prefix . '.title')->value($title)->title('Вопрос'),
        ];

        for ($key = 0; $key < $max; $key++) {
            if (isset($fields['list']) && is_array($fields['list'])) {
                if (array_key_exists($key, $fields['list'])) {
                    $item = $fields['list'][$key];
                }
                else{
                    $item = [
                        'answer' => '',
                        'point' => ''
                    ];
                }
                $list[] = Group::make([
                    Input::make($this->prefix . '.list.answer.')->value($item['answer'])->title('Вариант ' . ($key + 1))->size(80),
                    Input::make($this->prefix . '.list.point.')->value($item['point'])->title('Балл')->size(2)
                ])->autoWidth();
            } else {
                $list[] = Group::make([
                    Input::make($this->prefix . '.list.answer.')->value('')->title('Вариант ' . ($key + 1))->size(80),
                    Input::make($this->prefix . '.list.point.')->value('')->title('Балл')->size(2)
                ])->autoWidth();
            }
        }
        
        return $list;
    }
}
