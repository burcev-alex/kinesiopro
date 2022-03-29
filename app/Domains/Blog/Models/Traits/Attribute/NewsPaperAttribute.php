<?php
namespace App\Domains\Blog\Models\Traits\Attribute;
use Illuminate\Support\Carbon;

trait NewsPaperAttribute {

    public function getPublishDateAttribute()
    {
        $date_m = array('Null', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');

        return $this->publication_date ? $this->publication_date->format("d")." ".$date_m[$this->publication_date->format("n")] : '';
    }

    public function setAttachmentIdAttribute($id)
    {
        if(is_array($id))
            $this->attributes['attachment_id'] = $id[0];
        else 
            $this->attributes['attachment_id'] = $id;
    }

    public function setBannerAttachmentIdAttribute($id)
    {
        if(is_array($id))
            $this->attributes['detail_attachment_id'] = $id[0];
        else 
            $this->attributes['detail_attachment_id'] = $id;
    }
}