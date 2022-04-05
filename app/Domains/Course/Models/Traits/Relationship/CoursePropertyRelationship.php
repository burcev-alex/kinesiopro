<?php

namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;

trait CoursePropertyRelationship
{


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id', 'properties');
    }

    public function ref_char()
    {
        return $this->belongsTo(RefChar::class, 'ref_char_id', 'id', 'properties');
    }

    public function ref_char_value()
    {
        return $this->hasOne(RefCharsValue::class, 'id', 'ref_char_value_id');
    }
}
