<?php

namespace App\Domains\Online\Models\Traits\Scope;

trait OnlineScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
