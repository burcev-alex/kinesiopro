<?php

namespace App\Domains\Teacher\Models\Traits\Attribute;


use Intervention\Image\ImageManagerStatic as Image;
use File;

trait TeacherAttribute
{

    private function _defaultImage()
    {
        return '/img/png/photo_not_found.png';
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
