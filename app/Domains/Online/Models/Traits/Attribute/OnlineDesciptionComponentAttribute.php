<?php
namespace App\Domains\Online\Models\Traits\Attribute;

use App\Domains\Online\Models\OnlineDesciptionMedia;

trait OnlineDesciptionComponentAttribute {
    public function getMediaFieldsAttribute()
    {
        $fields = $this->fields;
        if(isset($fields['media']) && is_array(($fields['media'])))
        {
            foreach ($fields['media'] as $key => $value) {
                $media = OnlineDesciptionMedia::find($value);
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