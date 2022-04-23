<?php

namespace App\Domains\User\Models\Traits\Relationship;

/**
 * Class PermissionRelationship.
 */
trait PermissionRelationship
{
    /**
     * Родительские связь
     *
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id')->with('parent');
    }

    /**
     * Дочерние связи
     *
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id')->with('children');
    }
}
