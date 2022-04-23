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

    public function getIdentifMarkAttribute()
    {
        if(substr_count($this->url, "podcast-") > 0){
            $split = explode("podcast-", $this->url);
            $returned = '-'.$split[1];
        }
        else{
            $returned = '';
        }

        return $returned;
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
