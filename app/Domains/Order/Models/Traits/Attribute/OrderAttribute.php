<?php
namespace App\Domains\Order\Models\Traits\Attribute;
use Illuminate\Support\Carbon;

trait OrderAttribute {


    public function getCreatedAttribute()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }

    public function getCompletedAttribute()
    {
        return $this->created_at->format('d.m.Y H:i:s');
    }
}