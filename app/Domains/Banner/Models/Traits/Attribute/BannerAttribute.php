<?php

namespace App\Domains\Banner\Models\Traits\Attribute;


use Intervention\Image\ImageManagerStatic as Image;
use File;

trait BannerAttribute
{

    private function _defaultImage()
    {
        return '/images/photo_not_found.png';
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
