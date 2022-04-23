<?php
namespace App\Domains\Quiz\Models\Traits\Relationship;

use App\Domains\Quiz\Models\ItemQuestion;
use Orchid\Attachment\Models\Attachment;

trait ItemRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function banner()
    {
        return $this->hasOne(Attachment::class, 'id', 'detail_attachment_id');
    }

    public function questions()
    {
        return $this->hasMany(ItemQuestion::class, 'item_id', 'id')->with('question')->orderBy('sort');
    }
}
