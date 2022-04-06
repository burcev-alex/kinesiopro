<?php

namespace App\Domains\Podcast\Models\Traits\Attribute;

trait PodcastAttribute
{

    private function defaultImage()
    {
        return '/images/photo_not_found.png';
    }

    public function getPublishDateAttribute()
    {
        return $this->publication_date ? $this->publication_date->translatedFormat("d M") : '';
    }

    public function getPublishDateDayAttribute()
    {
        return $this->publication_date ? $this->publication_date->translatedFormat("d") : '';
    }

    public function getPublishDateMonthAttribute()
    {
        return $this->publication_date ? $this->publication_date->translatedFormat("M") : '';
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
