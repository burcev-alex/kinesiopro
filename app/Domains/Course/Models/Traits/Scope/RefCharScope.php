<?php
namespace App\Domains\Course\Models\Traits\Scope;

trait RefCharScope
{

    public function scopeAll($query)
    {
        return $query->orderBy('sort', 'ASC');
    }
}
