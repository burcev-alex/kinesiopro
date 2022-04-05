<?php
namespace App\Domains\Blog\Models\Traits\Attribute;

use Illuminate\Support\Carbon;

trait NewsPaperAttribute
{

    public function getPublishDateAttribute()
    {
        return $this->publication_date ? $this->publication_date->translatedFormat("d M") : '';
    }

    public function setAttachmentIdAttribute($id)
    {
        if (is_array($id)) {
            $this->attributes['attachment_id'] = $id[0];
        } else {
            $this->attributes['attachment_id'] = $id;
        }
    }

    public function setBannerAttachmentIdAttribute($id)
    {
        if (is_array($id)) {
            $this->attributes['detail_attachment_id'] = $id[0];
        } else {
            $this->attributes['detail_attachment_id'] = $id;
        }
    }
}
