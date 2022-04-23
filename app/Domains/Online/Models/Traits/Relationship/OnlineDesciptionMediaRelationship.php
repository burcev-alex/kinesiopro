<?php

namespace App\Domains\Online\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;

trait OnlineDesciptionMediaRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
