<?php

namespace App\Domains\Online\Models;

use App\Domains\Online\Models\Traits\Scope\OnlineScope;
use App\Domains\Online\Models\Traits\Attribute\OnlineAttribute;
use App\Domains\Online\Models\Traits\Relationship\OnlineRelationship;
use Database\Factories\OnlineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Online extends Model
{
    use HasFactory,
    Filterable,
    OnlineRelationship,
    OnlineAttribute,
    OnlineScope,
    AsSource;

    protected $fillable = [
        "title",
        "type",
        "slug",
        "active",
        "preview",
        "attachment_id",
        "start_date",
        "finish_date",
        "sort",
        "price",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected $casts = [
        "start_date" => "date",
        "finish_date" => "date",
    ];

    protected static function newFactory()
    {
        return OnlineFactory::new();
    }
}
