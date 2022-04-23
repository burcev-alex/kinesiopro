<?php

namespace App\Domains\Teacher\Models\Traits\Scope;

trait TeacherScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
