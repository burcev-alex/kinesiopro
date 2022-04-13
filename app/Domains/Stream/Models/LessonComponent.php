<?php

namespace App\Domains\Stream\Models;

use App\Domains\Stream\Models\Traits\Attribute\LessonComponentAttribute;
use App\Domains\Stream\Models\Traits\Relationship\LessonComponentRelationship;
use Illuminate\Database\Eloquent\Model;

class LessonComponent extends Model
{
    use LessonComponentAttribute, LessonComponentRelationship;

    protected $fillable = [
        "lesson_id",
        "component_id",
        "sort",
        "fields",
    ];
    protected $casts = [
        "fields" => "array",
    ];

    public $table = 'stream_lesson_components';
}
