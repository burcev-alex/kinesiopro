<?php

namespace App\Domains\Category\Models\Traits\Attribute;

trait CategoryAttribute
{
    /**
     * Get product image
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        $originPath = $this->attachment
            ? $this->attachment->relativeUrl
            : $this->defaultImage();

        // подмена origin на webp , если поддерживается формат
        if (isSupportWebP()) {
            // конвертировать исходник в webp
            $originPath = convertImageToWebP($originPath);
        }

        if (strlen($originPath) == 0) {
            $originPath = $this->attachment->url();
        }

        return $originPath;
    }
}
