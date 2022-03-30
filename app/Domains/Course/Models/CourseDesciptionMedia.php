<?php

namespace App\Domains\Course\Models;

use Illuminate\Database\Eloquent\Model;

class CourseDesciptionMedia extends Model
{
    protected $fillable = [
        "component_id",
        "attachment_id"
    ];

    public $table = 'courses_description_media';
}
