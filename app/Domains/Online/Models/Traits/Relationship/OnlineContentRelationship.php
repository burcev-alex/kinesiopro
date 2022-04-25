<?php

namespace App\Domains\Online\Models\Traits\Relationship;

use App\Domains\Online\Models\Online;
use App\Domains\Stream\Models\Stream;

trait OnlineContentRelationship
{
    public function stream()
    {
        return $this->hasOne(Stream::class, 'id', 'stream_id');
    }

    public function course()
    {
        return $this->hasOne(Online::class, 'id', 'online_id');
    }
}
