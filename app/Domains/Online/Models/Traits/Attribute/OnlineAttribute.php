<?php

namespace App\Domains\Online\Models\Traits\Attribute;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
trait OnlineAttribute
{

    /**
     * Название типа курса
     *
     * @return string
     */
    public function getTypeTitleAttribute()
    {
        $arr = [
            'marafon' => 'марафон',
            'course' => 'курс',
            'conference' => 'конференцию',
            'webinar' => 'вебинар',
            'video' => 'видео курс',
        ];

        return $arr[$this->type];
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

    private function defaultImage()
    {
        return '/images/photo_not_found.png';
    }

    public function getStartDateFormatAttribute()
    {
        return $this->start_date->translatedFormat('d F Y');
    }

    public function getDiffDayAttribute()
    {
        return $this->start_date->diff($this->finish_date)->days;
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
    
    public function getPreviewFormatAttribute(){
        return Str::limit(strip_tags($this->preview), 115);
    }
}
