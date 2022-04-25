<?php

namespace App\Domains\Online\Models\Traits\Relationship;

use App\Domains\Online\Models\OnlineContent;
use App\Domains\Online\Models\OnlineDesciptionComponent;
use App\Domains\Stream\Models\Stream;
use Orchid\Attachment\Models\Attachment;

trait OnlineRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function components()
    {
        return $this->hasMany(OnlineDesciptionComponent::class, 'online_id', 'id')->with('component')->orderBy('sort');
    }

    public function stream()
    {
        return $this->hasOneThrough(Stream::class, OnlineContent::class, 'online_id', 'id', 'id', 'stream_id');
    }
}
