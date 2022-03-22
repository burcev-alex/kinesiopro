<?php

namespace App\Domains\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "fields"
    ];

    protected $casts = [
        'fields' => "array"
    ];

    public $table = 'quiz_questions';
    
}
