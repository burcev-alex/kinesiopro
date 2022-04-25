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
use App;
use App\Domains\Course\Models\Traits\Scope\CourseScope;

class Course extends Model
{
    use HasFactory, 
    CourseScope, 
    CourseRelationship,
    AsSource,
    CourseAttribute,
    Filterable;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        "active",
        "slug",
        "marker_new",
        "marker_popular",
        "marker_archive",
        "category_id",
        "sort",
        "price",
        "name",
        "meta_h1",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "start_date",
        "finish_date",
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

    /**
     * Форматирование типов
     *
     * @var string[]
     */
    protected $casts = [];

    /**
     * Factory
     *
     * @return CourseFactory
     */
    protected static function newFactory()
    {
        return CourseFactory::new();
    }

    /**
     * Значения свойств
     *
     * @param string $slug
     * @param bool $first
     * @return array|mixed|null
     */
    public function getPropertyValues(string $slug, bool $first = true)
    {
        return Cache::tags('course_'.$this->id)->rememberForever('course_' . $this->id .'_property', function () use ($slug, $first) {
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
     *
     * @return mixed
     */
    public function fromCount()
    {
        return 0;
    }

    /**
     * Значения свойств сгруппированные по слагу
     *
     * @return mixed
     */
    public function getGroupedPropertiesBySlug()
    {
        return Cache::tags('course_'.$this->id)->rememberForever('course_' . $this->id . '_group_properties', function () {
            return $this->property_values->groupBy(function ($data) {
                return $data->chars->slug;
            });
        });
    }

    /**
     * Todo move such methods to chars values
     *
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
     *
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
     * Конвертация значения по типу
     *
     * @param string $value
     * @param string $type
     * @return int|string
     */
    protected function convertValueType(string $value, string $type)
    {
        $result = $value;

        switch ($type) {
            case 'float':
                $result = is_numeric($value) ? (float) $value : 0;
                break;
            case 'int':
                $result = is_numeric($value) ? (int) $value : 0;
                break;
            default:
                $result = (string) $value;
        }

        return $result;
    }
}
