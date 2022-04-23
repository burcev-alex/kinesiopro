<?php

namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use App\Domains\Teacher\Models\Teacher;

trait CourseBlockRelationship
{


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id', 'properties');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id', 'teachers');
    }
}
