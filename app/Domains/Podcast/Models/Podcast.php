<?php

namespace App\Domains\Podcast\Models;

use App\Domains\Podcast\Models\Traits\Scope\PodcastScope;
use App\Domains\Podcast\Models\Traits\Attribute\PodcastAttribute;
use App\Domains\Podcast\Models\Traits\Relationship\PodcastRelationship;
use Database\Factories\PodcastFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Podcast extends Model
{
    use HasFactory,
    PodcastRelationship,
    PodcastAttribute,
    PodcastScope,
    AsSource;

    protected $fillable = [
        "title",
        "slug",
        "active",
        "publication_date",
        "attachment_id",
        "sort",
        "description",
        "url",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected $casts = [
        "publication_date" => "date",
    ];

    protected static function newFactory()
    {
        return PodcastFactory::new();
    }
}
