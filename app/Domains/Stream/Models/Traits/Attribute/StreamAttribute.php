<?php
namespace App\Domains\Stream\Models\Traits\Attribute;


trait StreamAttribute
{
    public function setAttachmentIdAttribute($id)
    {
        if (is_array($id)) {
            $this->attributes['attachment_id'] = $id[0];
        } else {
            $this->attributes['attachment_id'] = $id;
        }
    }
}
