<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Relationship\RefCharValueRelationship;
use App\Domains\Course\Models\Traits\Scope\RefCharsValueScope;
use Database\Factories\RefCharValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefCharsValue extends Model
{
    use HasFactory,
    RefCharValueRelationship,
    RefCharsValueScope;

    protected $fillable = [
        "char_id",
        "value",
        "slug",
    ];


    protected static function newFactory()
    {
        return RefCharValueFactory::new();
    }
}
