<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\RefCharAttribute;
use App\Domains\Course\Models\Traits\Relationship\RefCharRelationship;
use App\Domains\Course\Models\Traits\Scope\RefCharScope;
use Database\Factories\RefCharFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * RefChar
 *
 * @method static RefCharScope property
 */
class RefChar extends Model
{
    use HasFactory,
    AsSource,
    RefCharRelationship,
    RefCharScope,
    RefCharAttribute;

    protected $fillable = [
        "slug",
        "name",
        "active",
        "sort",
    ];

    protected static function newFactory()
    {
        return RefCharFactory::new();
    }
}
