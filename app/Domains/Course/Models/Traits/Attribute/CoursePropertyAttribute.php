<?php
namespace App\Domains\Course\Models\Traits\Attribute;

trait CoursePropertyAttribute {

    public function getRefValueNameAttribute()
    {
        return $this->ref_char_value->value;
    }

}