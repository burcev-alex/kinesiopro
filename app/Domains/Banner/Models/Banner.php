<?php

namespace App\Domains\Banner\Models;

use App\Domains\Banner\Models\Traits\Attribute\BannerAttribute;
use App\Domains\Banner\Models\Traits\Relationship\BannerRelationship;
use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Banner extends Model
{
    use HasFactory,
    BannerRelationship,
    BannerAttribute,
    AsSource;

    protected $fillable = [
        "name",
        "time_organization",
        "place",
        "description",
        "attachment_id",
        "attachment_mobile_id",
        "sort",
        "active"
    ];

    protected static function newFactory()
    {
        return BannerFactory::new();
    }
    
}
