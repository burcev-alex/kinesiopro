<?php

namespace App\Domains\Course\Models\Traits\Attribute;


use Intervention\Image\ImageManagerStatic as Image;
use File;

trait CourseAttribute
{

    private function _defaultImage()
    {
        return '/img/png/photo_not_found.png';
    }

    /**
     * Detect product class name
     * @return string
     */
    function getMarkerClassAttribute()
    {
        if ($this->marker_new) {
            return 'new';
        }
        return '';
    }

    /**
     * Detect product class name
     * @return string
     */
    function getClassNewAttribute()
    {
        return $this->marker_new
            ? 'new'
            : '';
    }

    /**
     * `variants` relation must be included
     * @return string
     */
    function getAvailabilityClassAttribute()
    {
        return $this->marker_archive ? 'not-available' : ($this->available
            ? 'correct'
            : 'error');
    }
}
