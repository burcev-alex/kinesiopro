<?php

namespace App\Domains\Stream\Models;

use App\Domains\Stream\Models\Traits\Attribute\StreamAttribute;
use App\Domains\Stream\Models\Traits\Relationship\StreamRelationship;
use App\Domains\Stream\Models\Traits\Scope\StreamScope;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Stream extends Model
{
    use AsSource, StreamRelationship, StreamAttribute, StreamScope;

    protected $fillable = [
        "title",
        "slug",
        "active",
        "attachment_id",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected $casts = [
        "created_at" => "date",
    ];

    public $table = 'streams';
}
