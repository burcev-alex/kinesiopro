<?php

namespace App\Domains\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Log;
use Orchid\Attachment\Models\Attachment;

class ItemQuestion extends Model
{
    protected $fillable = [
        "item_id",
        "question_id",
        "sort",
        "fields",
    ];
    protected $casts = [
        "fields" => "array",
    ];

    public $table = 'quiz_item_questions';

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function getNameAttribute()
    {
        return $this->question->name;
    }
    public function getSlugAttribute()
    {
        return $this->question->slug;
    }

    public function getMediaFieldsAttribute()
    {
        $fields = $this->fields;
        
        return $fields;
    }
}
