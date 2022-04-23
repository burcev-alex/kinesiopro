<?php

namespace App\Domains\Podcast\Models\Traits\Scope;

trait PodcastScope
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
