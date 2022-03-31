<?php

namespace App\Domains\Podcast\Models\Traits\Attribute;


use Intervention\Image\ImageManagerStatic as Image;
use File;

trait PodcastAttribute
{

    private function _defaultImage()
    {
        return '/images/photo_not_found.png';
    }

    public function getPublishDateAttribute()
    {return $this->publication_date ? $this->publication_date->translatedFormat("d M") : '';
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
