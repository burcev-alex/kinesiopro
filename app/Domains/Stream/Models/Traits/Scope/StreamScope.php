<?php

namespace App\Domains\Stream\Models\Traits\Scope;

trait StreamScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
