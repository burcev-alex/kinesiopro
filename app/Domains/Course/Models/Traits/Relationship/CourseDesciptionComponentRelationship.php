<?php

namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Blog\Models\Component;

trait CourseDesciptionComponentRelationship
{

    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id');
    }
}
