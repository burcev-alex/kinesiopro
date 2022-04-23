<?php

namespace App\Domains\Stream\Models;

use App\Domains\Stream\Models\Traits\Relationship\LessonMediaRelationship;
use Illuminate\Database\Eloquent\Model;

class LessonMedia extends Model
{
    use LessonMediaRelationship;
    
    protected $fillable = [
        "component_id",
        "attachment_id",
    ];

    public $table = 'stream_lesson_media';
}
