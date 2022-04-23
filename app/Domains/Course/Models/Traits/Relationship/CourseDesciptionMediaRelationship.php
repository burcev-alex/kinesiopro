<?php

namespace App\Domains\Course\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait CourseDesciptionMediaRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
