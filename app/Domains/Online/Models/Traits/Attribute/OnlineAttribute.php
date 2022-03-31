<?php

namespace App\Domains\Online\Models\Traits\Attribute;

use Illuminate\Support\Carbon;

trait OnlineAttribute
{

    /**
     * Detect price format
     * @return string
     */
    function getPriceFormatAttribute()
    {
        return number_format($this->price, 0, '.', ' ');
    }

    private function _defaultImage()
    {
        return '/images/photo_not_found.png';
    }

    public function getStartDateFormatAttribute()
    {
        return $this->start_date->translatedFormat('d F Y');
    }
    
    function getAttachmentWebpAttribute()
    {
        $originPath = $this->attachment ? $this->attachment->relativeUrl : $this->_defaultImage();
        
        // подмена origin на webp , если поддерживается формат
        if (isSupportWebP()) {
            // конвертировать исходник в webp
            $originPath = convertImageToWebP($originPath);
        }
        return $originPath;
    }
}
