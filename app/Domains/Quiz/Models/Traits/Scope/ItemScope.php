<?php

namespace App\Domains\Quiz\Models\Traits\Scope;

trait ItemScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
