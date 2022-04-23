<?php
namespace App\Domains\Stream\Models\Traits\Relationship;

use App\Domains\Stream\Models\Lesson;
use Orchid\Attachment\Models\Attachment;

trait StreamRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'stream_id', 'id')->with('components')->orderBy('sort');
    }
}
