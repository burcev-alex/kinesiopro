<?php

namespace App\Domains\Podcast\Models\Traits\Attribute;


use Intervention\Image\ImageManagerStatic as Image;
use File;

trait PodcastAttribute
{

    private function _defaultImage()
    {
        return '/img/png/photo_not_found.png';
    }

    public function getPublishDateAttribute()
    {
        $date_m = array('Null', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');

        return $this->publication_date ? $this->publication_date->format("d")." ".$date_m[$this->publication_date->format("n")] : '';
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
