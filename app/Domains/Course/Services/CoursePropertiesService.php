<?php
namespace App\Domains\Course\Services;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Services\CourseService;
use Illuminate\Support\Facades\App;

class CoursePropertiesService
{
    protected CourseService $courseService;

    protected array $schema = [];

    protected array $groupedProperties;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;

        $arrRefProperties = RefChar::where('active', 1)->get()->pluck('slug')->toArray();
        foreach ($arrRefProperties as $slug) {
            $this->schema[$slug] = 'all';
        }
    }

    /**
     * Get general course properties
     *
     * @return array[]
     */
    public function getGeneralProperties()
    {
        return [];
    }

    /**
     * Вывод всех свойств курса
     *
     * @param Course $course
     * @return array
     */
    public function getFullListDescription(Course $course)
    {
        $grouped = $course->getGroupedPropertiesBySlug();
        
        $return = [];
        foreach ($this->schema as $key => $type) {
            $properties = $grouped->get($key);
            if (!$properties || $properties->isEmpty()) {
                continue;
            }
            if ($type == 'first') {
                $property = $properties->first();
                $return[] = [
                    'slug' => $property->chars->slug,
                    'name' => $property->chars->name,
                    'value' => $property->value,
                ];
            } elseif ($type == 'all') {
                $return[] = [
                    'slug' => $properties->first()->chars->slug,
                    'name' => $properties->first()->chars->name,
                    'value' => $properties->pluck('value')->implode(', '),
                ];
            } elseif ($type == 'min_max') {
                $min = $properties->min('value');
                $max = $properties->max('value');
                $property = $properties->first();
                $return[] = [
                    'slug' => $property->chars->slug,
                    'name' => $property->chars->name,
                    'value' => $min . '-' . $max,
                ];
            }
        }
        
        return $return;
    }

    /**
     * Свойств, которые необхоимы для товаров в корзине
     *
     * @param Course $course
     * @return array
     */
    public function getCartPropertiesFull(Course $course)
    {
        $grouped = $course->getGroupedPropertiesBySlug();
        
        $schema = [
            'city' => 'Город',
        ];
        $return = [];
        foreach ($schema as $key => $title) {
            $properties = $grouped->get($key);
            if (!$properties || $properties->isEmpty()) {
                $value = '';
            } else {
                $value = $properties->pluck('value')->implode(', ');
            }

            $return[$key] = [
                'key' => $key,
                'name' => $title,
                'value' => $value,
            ];
        }
        return $return;
    }
}
