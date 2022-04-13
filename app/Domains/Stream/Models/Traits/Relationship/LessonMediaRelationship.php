<?php
namespace App\Domains\Stream\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait LessonMediaRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
