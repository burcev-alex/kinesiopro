<?php
namespace App\Domains\Course\Models\Traits\Attribute;

use App\Domains\Course\Models\CourseDesciptionMedia;

trait CourseDesciptionComponentAttribute {
    public function getMediaFieldsAttribute()
    {
        $fields = $this->fields;
        if(isset($fields['media']) && is_array(($fields['media'])))
        {
            foreach ($fields['media'] as $key => $value) {
                $media = CourseDesciptionMedia::find($value);
                $value = $media->attachment;
                $fields['media'][$key] = $value;
             }
        } else 
            unset($fields['media']);
        return $fields;
    }

    public function getNameAttribute()
    {
        return  $this->component->name;
    }
    public function getSlugAttribute()
    {
        return  $this->component->slug;
    }
}