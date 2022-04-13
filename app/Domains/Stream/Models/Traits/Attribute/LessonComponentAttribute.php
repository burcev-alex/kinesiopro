<?php
namespace App\Domains\Stream\Models\Traits\Attribute;

use App\Domains\Stream\Models\LessonMedia;

trait LessonComponentAttribute
{
    public function getNameAttribute()
    {
        return $this->component->name;
    }
    
    public function getSlugAttribute()
    {
        return $this->component->slug;
    }

    public function getMediaFieldsAttribute()
    {
        $fields = $this->fields;
        if (isset($fields['media']) && is_array(($fields['media']))) {
            foreach ($fields['media'] as $key => $value) {
                $media = LessonMedia::find($value);
                $value = $media->attachment;
                $fields['media'][$key] = $value;
            }
        } else {
            unset($fields['media']);
        }
        return $fields;
    }
}
