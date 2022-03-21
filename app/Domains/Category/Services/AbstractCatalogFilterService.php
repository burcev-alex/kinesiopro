<?php
namespace App\Domains\Category\Services;

use App\Domains\Course\Services\CategoryService;
use App\Domains\Course\Services\RefCharService;

abstract class AbstractCatalogFilterService
{
    // Наличие курсов
    public const COURSE_EXITS = 1;

    protected CategoryService $categoryService;
    protected RefCharService $refCharService;

    protected int $totalCourses;
    protected int $selectedCourses;


    public function __construct()
    {
        $this->categoryService = app(CategoryService::class);
        $this->refCharService = app(RefCharService::class);
    }

    /**
     * @var array|string[]
     */
    protected array $filtersMethods = [
        'text' => 'string',
        'sort' => 'string',
        'numbers' => 'float',

        // Filters taken from multiple select
        'categories' => 'array',
    ];

    /**
     * @return int
     */
    public function gettotalCourses(): int
    {
        return $this->totalCourses ?? 0;
    }

    /**
     * @return int
     */
    public function getSelectedCountProducts(): int
    {
        return $this->selectedCourses ?? 0;
    }

    /**
     * Get list of categories ids start from first level
     * @param array $categories
     * @return array
     * @throws \Exception
     */
    protected function getCategoriesIdsBySlugs(array $categories): array
    {
        $ids = [];
        if (empty($categories)) {
            return $ids;
        }

        // удалить корневой раздел
        foreach($categories as $key=>$slug){
            if($slug == 'categories'){
                unset($categories[$key]);
            }
        }
        
        $groupedCategories = $this->categoryService->getGroupedCategories();
        $current = $groupedCategories;
        
        foreach ($categories as $category) {
            $current = $current[$category] ?? $current['children'][$category] ?? [];
            if ($current) {
                $ids = empty($ids) ? $current['ids'] : array_intersect($ids, $current['ids']);
            }
        }
        
        return array_values($ids);
    }

    /**
     * Parse filters
     * @param string $filters
     * @return array
     */
    public function parseFilters(string $filters, bool $parseKey = true) {
        $return = [];
        foreach (explode(';', $filters) as $filter) {
            $filterArray = explode('=', $filter);
            if (empty($filterArray[1])) {
                continue;
            }
            // Parse key
            $keyArray = explode('__', $filterArray[0]);
            // Parse value
            if (count($keyArray) == 2 && $parseKey) {
                $return[$keyArray[0]][$keyArray[1]] = $this->parseValue($keyArray[0], $filterArray[1]);
            } else {
                $return[$filterArray[0]] = $this->parseValue($filterArray[0], $filterArray[1]);
            }
        }
        return $return;
    }

    /**
     * Parse value
     * @param string $key
     * @param string $value
     * @return float|string|string[]
     */
    protected function parseValue(string $key, string $value) {
        $type = $this->filtersMethods[$key] ?? 'array';
        switch ($type) {
            case 'array':
                return explode(',', $value);
            case 'float':
                return (float) $value;
            case 'int':
                return (int) $value;
            default:
                return $value;
        }
    }
}
