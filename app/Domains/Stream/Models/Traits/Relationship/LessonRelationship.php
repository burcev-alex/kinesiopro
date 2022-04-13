<?php
namespace App\Domains\Stream\Models\Traits\Relationship;

use App\Domains\Stream\Models\LessonComponent;
use Orchid\Attachment\Models\Attachment;

trait LessonRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function components()
    {
        return $this->hasMany(LessonComponent::class, 'lesson_id', 'id')->with('component')->orderBy('sort');
    }
}
