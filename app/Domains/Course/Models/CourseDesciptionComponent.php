<?php

namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\CourseDesciptionComponentAttribute;
use App\Domains\Course\Models\Traits\Relationship\CourseDesciptionComponentRelationship;
use Illuminate\Database\Eloquent\Model;

class CourseDesciptionComponent extends Model
{
    use CourseDesciptionComponentAttribute,
    CourseDesciptionComponentRelationship;

    protected $fillable = [
        "course_id",
        "component_id",
        "sort",
        "fields",
    ];
    protected $casts = [
        "fields" => "array",
    ];

    public $table = 'courses_description_components';
}
