<?php
namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseBlock;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\CourseTeacher;
use App\Domains\Course\Models\RefCharsValue;
use App\Domains\Teacher\Models\Teacher;

trait CourseRelationship {

    public function teachers()
    {
        return $this->hasManyThrough(Teacher::class, CourseTeacher::class, 'course_id', 'id', 'id', 'teacher_id');
    }

    public function properties()
    {
        return $this->hasMany(CourseProperty::class, 'course_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(CourseBlock::class, 'course_id', 'id')->orderBy('sort');
    }

    public function property_values()
    {
        return $this->hasManyThrough(RefCharsValue::class, CourseProperty::class, 'course_id', 'id', 'id', 'ref_char_value_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
