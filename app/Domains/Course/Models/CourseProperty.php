<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\CoursePropertyAttribute;
use App\Domains\Course\Models\Traits\Relationship\CoursePropertyRelationship;
use Database\Factories\CoursePropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProperty extends Model
{
    use HasFactory,
    CoursePropertyRelationship,
    CoursePropertyAttribute;

    protected $fillable = [
        "course_id",
        "ref_char_value_id",
        "ref_char_id",
    ];

    protected $table = 'courses_properties';


    protected static function newFactory()
    {
        return CoursePropertyFactory::new();
    }
}
