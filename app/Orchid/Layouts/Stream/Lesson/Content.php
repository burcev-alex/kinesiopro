<?php

namespace App\Orchid\Layouts\Stream\Lesson;

use App\Orchid\Layouts\Stream\StreamLesson;
use App\Orchid\Layouts\Stream\Interfaces\StreamLessonInterface;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;

class Content extends StreamLesson implements StreamLessonInterface
{
    public function render(): array
    {
        $title = $this->lesson ? $this->lesson->title : '';
        $slug = $this->lesson ? $this->lesson->slug : '';
        $streamId = $this->lesson ? $this->lesson->stream_id : 0;
        
        $rows = [
            Input::make($this->prefix . '.slug')->type('hidden')->value($slug)->title('Символьный код')->required(),
            Input::make($this->prefix . '.title')->value($title)->title('Название')->required(),
        ];

        if(intval($streamId) > 0){
            $rows[] = Link::make('Изменение содержимого лекции')->route('platform.stream.edit.lesson.edit', ['stream'=> $streamId, 'lesson' => $this->lesson->id]);
        }

        return $rows;
    }
}
