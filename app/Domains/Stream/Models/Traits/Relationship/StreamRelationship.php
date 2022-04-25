<?php
namespace App\Domains\Stream\Models\Traits\Relationship;

use App\Domains\Online\Models\Online;
use App\Domains\Online\Models\OnlineContent;
use App\Domains\Stream\Models\Lesson;
use App\Domains\Stream\Models\Stream;
use Orchid\Attachment\Models\Attachment;

trait StreamRelationship
{
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'stream_id', 'id')->with('components')->orderBy('sort');
    }

    public function online()
    {
        return $this->hasOneThrough(Online::class, OnlineContent::class, 'stream_id', 'id', 'id', 'online_id');
    }
}
