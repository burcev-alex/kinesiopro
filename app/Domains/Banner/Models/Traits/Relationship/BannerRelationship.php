<?php

namespace App\Domains\Banner\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait BannerRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
    public function attachment_mobile()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_mobile_id');
    }
}
