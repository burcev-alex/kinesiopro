<?php

namespace App\Domains\Course\Models\Traits\Attribute;

use Intervention\Image\ImageManagerStatic as Image;
use File;

trait CourseAttribute
{

    private function defaultImage()
    {
        return '/images/photo_not_found.png';
    }

    public function getDiffDayAttribute()
    {
        return $this->start_date->diff($this->finish_date)->days;
    }

    /**
     * Detect product class name
     *
     * @return string
     */
    public function getMarkerClassAttribute()
    {
        if ($this->marker_new) {
            return 'new';
        }
        return '';
    }

    /**
     * Detect product class name
     *
     * @return string
     */
    public function getClassNewAttribute()
    {
        return $this->marker_new
            ? 'new'
            : '';
    }

    /**
     * Detect price format
     *
     * @return string
     */
    public function getPriceFormatAttribute()
    {
        return number_format($this->price, 0, '.', ' ');
    }
    
    public function getAvailabilityClassAttribute()
    {
        return $this->marker_archive ? 'not-available' : ($this->available
            ? 'correct'
            : 'error');
    }
    
    public function getCityDisplayAttribute()
    {
        return implode(', ', $this->property_values->filter(function ($prop) {
            return ($prop->char->slug == 'city');
        })->pluck('value')->toArray());
    }
    
    public function getFormatDisplayAttribute()
    {
        return implode(', ', $this->property_values->filter(function ($prop) {
            return $prop->char->slug == 'format';
        })->pluck('value')->toArray());
    }
}
