<?php

namespace App\Domains\Category\Models;

use App\Domains\Category\Models\Traits\Attribute\CategoryAttribute;
use App\Domains\Category\Models\Traits\Relationship\CategoryRelationship;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Category extends Model
{
    use HasFactory,
    CategoryRelationship,
    AsSource,
    Filterable,
    CategoryAttribute;

    protected $fillable = [
        "slug",
        "name",
        "active",
        "sort",
        "attachment_id",
        "description",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
    
}
