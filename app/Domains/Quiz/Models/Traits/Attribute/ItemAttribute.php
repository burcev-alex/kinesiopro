<?php
namespace App\Domains\Quiz\Models\Traits\Attribute;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait ItemAttribute
{

    public function getPreviewFormatAttribute(){
        return Str::limit(strip_tags($this->preview), 260);
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
