<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\CourseBlockAttribute;
use App\Domains\Course\Models\Traits\Relationship\CourseBlockRelationship;
use Database\Factories\CourseBlockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseBlock extends Model
{
    use HasFactory,
    CourseBlockRelationship,
    CourseBlockAttribute;

    protected $fillable = [
        "course_id",
        "title",
        "sort",
        "start_date",
        "finish_date",
        "teacher_id",
        "description",
    ];

    /**
     * Даты
     *
     * @var string[]
     */
    protected $dates = [
        "start_date",
        "finish_date",
    ];

    protected $table = 'courses_blocks';


    protected static function newFactory()
    {
        return CourseBlockFactory::new();
    }
}
