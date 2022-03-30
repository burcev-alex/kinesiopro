<?php 

namespace App\Domains\Online\Models\Traits\Relationship;

use App\Domains\Online\Models\OnlineDesciptionComponent;
use Orchid\Attachment\Models\Attachment;

trait OnlineRelationship {
    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function components()
    {
        return $this->hasMany(OnlineDesciptionComponent::class, 'online_id', 'id')->with('component')->orderBy('sort');
    }
}