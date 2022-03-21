<?php

namespace App\Domains\Teacher\Services;

use App\Services\BaseService;
use App\Domains\Teacher\Models\Teacher;
use App\Exceptions\NoPageException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class TeachersService extends BaseService
{
    /**
     * __construct
     *
     * @param  Teacher $teacher
     * @return void
     */
    public function __construct(Teacher $teacher)
    {
        $this->model = $teacher;
    }

    public function save(array $fields): self
    {
        $this->model->fill($fields['teacher']);
        if (isset($fields['teacher']['active'])) $this->model->active = true;
        else $this->model->active = false;


        $this->model->save();

        return $this;
    }

    public function saveImages(array $images)
    {
        
        if(!isset($images['attachment_id'])) $images['attachment_id'] = [];        
        
        foreach($images as $key => $items){
            foreach($items as $item){
                Teacher::where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }
}
