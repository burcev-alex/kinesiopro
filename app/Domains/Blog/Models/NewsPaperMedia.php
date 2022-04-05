<?php

namespace App\Domains\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Models\Attachment;

class NewsPaperMedia extends Model
{
    protected $fillable = [
        "component_id",
        "attachment_id",
    ];

    public $table = 'blog_news_paper_media';

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
