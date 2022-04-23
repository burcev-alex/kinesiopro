<?php

namespace App\Domains\Podcast\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait PodcastRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
