<?php

namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use App\Domains\Teacher\Models\Teacher;

trait CourseTeacherRelationship
{


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id', 'teachers');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }
}
