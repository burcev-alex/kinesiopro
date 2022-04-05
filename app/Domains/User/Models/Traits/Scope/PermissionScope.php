<?php

namespace App\Domains\User\Models\Traits\Scope;

/**
 * Class PermissionScope.
 */
trait PermissionScope
{
    /**
     * Мастер
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsMaster($query)
    {
        return $query->whereDoesntHave('parent')
            ->whereHas('children');
    }

    /**
     * Родитель
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsParent($query)
    {
        return $query->whereHas('children');
    }

    /**
     * Ребенок
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeIsChild($query)
    {
        return $query->whereHas('parent');
    }

    /**
     * Сигнатура
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeSingular($query)
    {
        return $query->whereNull('parent_id')
            ->whereDoesntHave('children');
    }
}
