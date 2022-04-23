<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\CourseTeacherAttribute;
use App\Domains\Course\Models\Traits\Relationship\CourseTeacherRelationship;
use Database\Factories\CourseTeacherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    use HasFactory,
    CourseTeacherRelationship,
    CourseTeacherAttribute;

    protected $fillable = [
        "course_id",
        "teacher_id",
    ];

    public $timestamps = false;

    protected $table = 'courses_teachers';


    protected static function newFactory()
    {
        return CourseTeacherFactory::new();
    }
}
