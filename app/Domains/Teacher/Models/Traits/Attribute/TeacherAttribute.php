<?php

namespace App\Domains\Teacher\Models\Traits\Attribute;

use Intervention\Image\ImageManagerStatic as Image;
use File;

trait TeacherAttribute
{

    private function defaultImage()
    {
        return '/images/photo_not_found.png';
    }
    
    public function getAttachmentWebpAttribute()
    {
        $originPath = $this->attachment ? $this->attachment->relativeUrl : $this->defaultImage();
        
        // подмена origin на webp , если поддерживается формат
        if (isSupportWebP()) {
            // конвертировать исходник в webp
            $originPath = convertImageToWebP($originPath);
        }
        return $originPath;
    }
}
