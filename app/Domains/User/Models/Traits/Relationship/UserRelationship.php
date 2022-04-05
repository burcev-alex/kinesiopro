<?php

namespace App\Domains\User\Models\Traits\Relationship;

use Orchid\Attachment\Models\Attachment;
/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    public function picture()
    {
        return $this->hasOne(Attachment::class, 'id', 'avatar_id');
    }

    public function scan()
    {
        return $this->hasOne(Attachment::class, 'id', 'scan_id');
    }

}
