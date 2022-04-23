<?php

namespace App\Domains\Teacher\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait TeacherRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
