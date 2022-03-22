<?php

namespace App\Domains\Blog\Models\Traits\Scope;

trait NewsPaperScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
