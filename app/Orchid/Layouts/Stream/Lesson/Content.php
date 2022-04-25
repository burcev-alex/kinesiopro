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
        $streamId = $this->lesson ? $this->lesson->stream_id : 0;
        
        $rows = [
            Input::make($this->prefix . '.slug')->type('hidden')->value($this->lesson->slug)->title('Символьный код')->required(),
            Input::make($this->prefix . '.title')->value($this->lesson->title)->title('Название')->required(),
        ];

        if(intval($streamId) > 0){
            $rows[] = Link::make('Изменение содержимого лекции')->route('platform.stream.edit.lesson.edit', ['stream'=> $streamId, 'lesson' => $this->lesson->id]);
        }

        return $rows;
    }
}
