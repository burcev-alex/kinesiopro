<?php
namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\RefCharsValue;
use Illuminate\Support\Facades\DB;

trait RefCharRelationship{

    public function values()
    {
        return $this->hasMany(RefCharsValue::class, 'char_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany(CourseProperty::class, 'ref_char_id', 'id');
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, CourseProperty::class, 'ref_char_id', 'id', 'id', 'course_id')->select([DB::raw('courses.id'), DB::raw('courses.category_id'), DB::raw('courses_properties.ref_char_value_id')]);
    }
}
