<?php
namespace App\Domains\Blog\Models\Traits\Relationship;

use App\Domains\Blog\Models\NewsPaperComponent;
use Orchid\Attachment\Models\Attachment;

trait NewsPaperRelationship
{

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }

    public function banner()
    {
        return $this->hasOne(Attachment::class, 'id', 'detail_attachment_id');
    }

    public function components()
    {
        return $this->hasMany(NewsPaperComponent::class, 'news_paper_id', 'id')->with('component')->orderBy('sort');
    }
}
