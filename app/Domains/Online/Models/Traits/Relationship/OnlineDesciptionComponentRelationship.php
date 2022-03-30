<?php 

namespace App\Domains\Online\Models\Traits\Relationship;

use App\Domains\Blog\Models\Component;

trait OnlineDesciptionComponentRelationship{

    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id');
    }

}