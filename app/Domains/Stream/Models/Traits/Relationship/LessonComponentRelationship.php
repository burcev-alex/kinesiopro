<?php
namespace App\Domains\Stream\Models\Traits\Relationship;

use App\Domains\Stream\Models\Component;

trait LessonComponentRelationship
{
    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id');
    }
}
