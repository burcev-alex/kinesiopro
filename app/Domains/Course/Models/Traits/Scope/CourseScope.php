<?php
namespace App\Domains\Course\Models\Traits\Scope;

trait CourseScope
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
