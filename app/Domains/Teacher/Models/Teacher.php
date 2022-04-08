<?php

namespace App\Domains\Teacher\Models;

use App\Domains\Teacher\Models\Traits\Attribute\TeacherAttribute;
use App\Domains\Teacher\Models\Traits\Relationship\TeacherRelationship;
use App\Domains\Teacher\Models\Traits\Scope\TeacherScope;
use Database\Factories\TeacherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Teacher extends Model
{
    use HasFactory,
    TeacherRelationship,
    TeacherAttribute, 
    TeacherScope, 
    AsSource;

    protected $fillable = [
        "full_name",
        "slug",
        "attachment_id",
        "sort",
        "description",
        "education",
        "certificates",
        "specialization",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "active",
    ];

    protected static function newFactory()
    {
        return TeacherFactory::new();
    }
}
