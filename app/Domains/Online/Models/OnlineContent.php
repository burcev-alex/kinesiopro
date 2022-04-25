<?php

namespace App\Domains\Online\Models;

use App\Domains\Online\Models\Traits\Scope\OnlineContentScope;
use App\Domains\Online\Models\Traits\Attribute\OnlineContentAttribute;
use App\Domains\Online\Models\Traits\Relationship\OnlineContentRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class OnlineContent extends Model
{
    use HasFactory,
    Filterable,
    OnlineContentRelationship,
    OnlineContentAttribute,
    OnlineContentScope,
    AsSource;

    protected $fillable = [
        "online_id",
        "stream_id",
    ];

    public $table = 'onlines_content';
}
