<?php
namespace App\Domains\Course\Models\Traits\Attribute;

trait CourseBlockAttribute {
    public function getDiffDayAttribute()
    {
        return $this->start_date->diff($this->finish_date)->days;
    }
}