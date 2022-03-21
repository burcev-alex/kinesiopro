<?php
namespace App\Domains\Course\Models;

use App\Domains\Course\Models\Traits\Attribute\CourseAttribute;
use App\Domains\Course\Models\Traits\Relationship\CourseRelationship;
use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use App\Domains\Order\Facades\Cart;
use App;

class Course extends Model
{
    use HasFactory,
    CourseRelationship,
    AsSource,
    CourseAttribute,
    Filterable;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        "active",
        "slug",
        "marker_new",
        "marker_popular",
        "marker_archive",
        "sort",
        "price",
        "name",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "description",
        "teacher_id",
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        "start_date",
        "finish_date",
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'teacher_id' => 'array',
    ];

    /**
     * @return CourseFactory
     */
    protected static function newFactory()
    {
        return CourseFactory::new();
    }

    /**
     * @param string $slug
     * @param bool $first
     * @return array|mixed|null
     */
    public function getPropertyValues(string $slug, bool $first = true)
    {
        return Cache::tags('course_'.$this->id)->rememberForever('course_' . $this->id .'_property', function() use($slug, $first) {
            $return = [];
            foreach ($this->property_values as $propertyValue) {
                if ($propertyValue->chars->slug == $slug) {
                    $return[] = $propertyValue;
                }
            }
            return $first
                ? array_shift($return)
                : $return;
        });
    }

    /**
     * From count
     * @return mixed
     */
    public function fromCount()
    {
        return 0;
    }

    /**
     * @return mixed
     */
    public function getGroupedPropertiesBySlug()
    {
        return Cache::tags('course_'.$this->id)->rememberForever('course_' . $this->id . '_group_properties', function() {
            return $this->property_values->groupBy(function ($data) {
                return $data->chars->slug;
            });
        });
    }

    /**
     * Todo move such methods to chars values
     * @param string $slug
     * @param string $type
     * @param bool $all
     * @return string|void|array
     */
    public function getPropertyValueBySlug(string $slug, string $type = 'string', bool $all = false)
    {
        $grouped = $this->getGroupedPropertiesBySlug();

        $return = [];
        if ($grouped && !$grouped->isEmpty()) {
            $values = $grouped->get($slug);
            if ($values && !$values->isEmpty()) {
                foreach ($values as $value) {
                    // Convert values
                    $return[] = $this->convertValueType($value->value, $type);
                }
            }
        }

        return $all ? $return : array_shift($return);
    }

    /**
     * Todo move such methods to chars values
     * @param string $slug
     * @return array
     */
    public function getPropertyValueSlugsByCharSlug(string $slug)
    {
        $grouped = $this->getGroupedPropertiesBySlug();
        $return = [];
        if ($grouped && !$grouped->isEmpty()) {
            $values = $grouped->get($slug);
            if ($values && !$values->isEmpty()) {
                foreach ($values as $value) {
                    // Convert values
                    $return[] = $value->slug;
                }
            }
        }

        return $return;
    }

    /**
     * @param string $value
     * @param string $type
     * @return int|string
     */
    protected function convertValueType(string $value, string $type)
    {
        // Convert type
        switch ($type) {
            case 'float':
                $value = is_numeric($value)
                    ? (float) $value
                    : 0;
            case 'int':
                $value = is_numeric($value)
                    ? (int) $value
                    : 0;
        }
        return $value;
    }
}
