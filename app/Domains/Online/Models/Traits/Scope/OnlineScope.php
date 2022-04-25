<?php

namespace App\Domains\Online\Models\Traits\Scope;

trait OnlineScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'LIKE', "%$value%");
    }
}
