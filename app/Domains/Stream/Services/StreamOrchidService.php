<?php
namespace App\Domains\Stream\Services;

use App\Domains\Stream\Models\Lesson;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Orchid\Attachment\Models\Attachment;

class StreamOrchidService extends StreamService
{

    protected $group = null;

    /**
     * Сохраняет личные поля модели
     *
     * @param  array $fields
     * @return self
     */
    public function save(array $fields): self
    {
        if (!isset($fields['active'])) {
            $fields['active'] = 0;
        } elseif (isset($fields['active'])) {
            $fields['active'] = 1;
        }
        
        $this->model->fill($fields)->save();

        Cache::tags(['streams'])->flush();
        
        return $this;
    }

    /**
     * Сохранение данных по всем лекциям
     *
     * @param array $lessons
     * @return void
     */
    public function saveLessons(array $lessons)
    {
        foreach ($lessons as $lesson) {
            Lesson::updateOrCreate([
                "stream_id" => $this->model->id,
                "slug" => $lesson['slug']
            ], [
                "title" => $lesson['title'],
                "sort" => $lesson['sort'],
            ]);
        }
        return $this;
    }
}
