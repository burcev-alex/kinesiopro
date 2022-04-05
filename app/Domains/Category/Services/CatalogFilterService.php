<?php

namespace App\Domains\Category\Services;

use App\Domains\Course\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Domains\Course\Services\Elastic;
use App;
use App\Domains\Category\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CatalogFilterService extends AbstractCatalogFilterService
{
    // SORT TYPES
    public const DEFAULT_COURSE_SORT = 1,
        DEFAULT_COURSE_SEARCH_SORT = 2,
        DEFAULT_FAVORITE_SORT = 4,
        CUSTOM_SEARCH = 3;

    public const DEFAULT_SORT_DIRECTION = 'desc';

    public const DEFAULT_LIMIT = 8;

    protected Builder $query;

    /**
     * Sort by slug // 'slug' => ['column'=>'', 'direction' => '']
     *
     * @var array|\string[][]
     */
    protected array $sorts = [
        'sort' => [
            'column' => 'sort',
            'direction' => 'asc',
        ],
        'max_price' => [
            'column' => 'price',
            'direction' => 'desc',
        ],
        'min_price' => [
            'column' => 'price',
            'direction' => 'asc',
        ],
        'date' => [
            'column' => 'created_at',
            'direction' => 'asc',
        ]
    ];

    protected array $numbers = [3, 15, 30, 60, 120];

    protected array $categoryIds = [];
    protected array $categoriesSlug = [];

    /**
     * Show which sort is set currently and by default
     *
     * @var integer
     */
    protected int $currentSortType;
    protected int $defaultSortType = self::DEFAULT_COURSE_SORT;
    protected bool $isFavorites = false;

    // кол-во элементов на странице
    protected int $currentLimitPage;
    // значение по умолчанию
    protected int $defaultLimitPage = self::DEFAULT_LIMIT;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->query = Course::query()->select('courses.*')->where('courses.active', 1);
        parent::__construct();
    }

    /**
     * Get total of Courses in catalog
     *
     * @return int
     */
    public function getTotalCourses(): int
    {
        if (!isset($this->totalCourses)) {
            $this->totalCourses = $this->query->count();
        }
        return $this->totalCourses;
    }
    
    /**
     * Список разделов, участвующие в фильтрации
     *
     * @return array
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * Проверка на избранное
     *
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->isFavorites;
    }

    /**
     * Set filter by categories to catalog
     *
     * @param ...$categories
     * @return $this
     */
    public function setCategories(...$categories)
    {
        $categories = array_filter($categories, function ($value) {
            return !empty($value);
        });

        $this->categoriesSlug = $categories;

        // Set categories filters
        $ids = $this->getCategoriesIdsBySlugs($categories);
            
        if (!empty($ids)) {
            $this->categoryIds = $ids;

            $this->attachCategoriesIds($ids);
        }

        return $this;
    }

    /**
     * Get Courses Category information
     *
     * @return Category
     */

    public function getCategoryInfo()
    {
        if (!empty($this->categoriesSlug)) {
            return Category::where('slug', end($this->categoriesSlug))->first();
        } else {
            return;
        }
    }

    /**
     * Set Default Sort Type
     *
     * @param int $type
     * @return $this
     */
    public function setDefaultSortType(int $type)
    {
        $this->defaultSortType = $type;
        return $this;
    }

    /**
     * Use different object for getAvailableProperties and getCatalog
     *
     * @param string $filters
     * @return array
     */
    public function getAvailableProperties(string $filters)
    {
        $this->query->with([
            'properties' => function ($query) {
                return $query->select(['course_id', 'ref_char_id', 'ref_char_value_id']);
            },
        ]);
        
        if (count($this->categoryIds) > 0) {
            $this->attachCategoriesIds($this->categoryIds);
        }

        $categoryCourses = $this->query->get('id');
        
        $availableCharsForCategory = [];
        foreach ($categoryCourses as $course) {
            foreach ($course->properties ?? [] as $property) {
                if (isset($availableCharsForCategory[$property->ref_char_id])) {
                    $availableCharsForCategory[$property->ref_char_id][] = $property->ref_char_value_id;
                } else {
                    $availableCharsForCategory[$property->ref_char_id] = [$property->ref_char_value_id];
                }
            }
        }

        foreach ($availableCharsForCategory as &$item) {
            $item = array_unique($item);
        }

        $this->attachFilters($filters);

        $courses = $this->query->get(['id']);
        
        // собираем данные через эластик
        $aggregationCollection = [];
        $availableChars = [];

        
        $this->selectedCourses = $courses->count();

        return [$availableChars, $availableCharsForCategory, $aggregationCollection];
    }

    /**
     * Get Courses catalog
     *
     * @param string $filters
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCatalog(string $filters, int $page = 1)
    {
        $this->attachFilters($filters);

        if (!isset($this->currentSortType)) {
            $this->attachDefaultSort();
        }

        if (!isset($this->currentLimitPage)) {
            $this->attachLimitPagination();
        }
          
        $builder = $this->query->with([
            'property_values' => function ($query) {
                return $query->with('chars', function ($query) {
                    return $query->where('active', 1)->get()->toArray();
                });
            },
            'teachers',
            'blocks'
        ]);

        $result = $builder->paginate($this->currentLimitPage, ['*'], 'page', $page);
        
        return $result;
    }

    /**
     * Attach Filters
     *
     * @param string $filters
     * @return $this
     */
    protected function attachFilters(string $filters)
    {
        $properties = [];
        foreach ($this->parseFilters($filters) as $key => $values) {
            if (array_key_exists($key, $this->filtersMethods)) {
                $function = $this->getFunctionName($key);
                if (method_exists($this, $function)) {
                    // Attach filter only if filter exists
                    $this->{$function}($values);
                }
            } else {
                $properties[$key] = $values;
            }
        }

        if (!empty($properties)) {
            $this->attachProperties($properties);
        }

        return $this;
    }

    /**
     * Set default sort to Courses
     */
    protected function attachDefaultSort()
    {
        $column = 'courses.sort, courses.id';
        $this->query->orderBy(DB::raw($column), self::DEFAULT_SORT_DIRECTION);
        $this->currentSortType = $this->defaultSortType;
    }

    /**
     * Set default limit pagination
     */
    protected function attachLimitPagination()
    {
        $this->currentLimitPage = $this->defaultLimitPage;
    }


    /**
     * Attach properties
     *
     * @param $properties
     */
    protected function attachProperties($properties)
    {
        $chars = $this->refCharService->getCharsGroupedBySlug();
        $filtered = [];
        foreach ($properties as $key => $values) {
            if (isset($chars[$key])) {
                $char = $chars[$key];
                foreach ($char['values'] as $value) {
                    if (in_array($value['slug'], $values)) {
                        if (isset($filtered[$char['id']])) {
                            $filtered[$char['id']][] = $value['id'];
                        } else {
                            $filtered[$char['id']] = [$value['id']];
                        }
                    }
                }
            }
        }
        
        if (!empty($filtered)) {
            foreach ($filtered as $refCharId => $refCharValueIds) {
                // Взять пересечение всех фильтров
                $this->query->whereHas('properties', function (Builder $query) use ($refCharId, $refCharValueIds) {
                    return $query->where(function ($query) use ($refCharId, $refCharValueIds) {
                        return $query->where('ref_char_id', $refCharId)
                            ->whereIn('ref_char_value_id', $refCharValueIds);
                    });
                });
            }
            $this->query->where('marker_archive', 0);
        }
    }

    /**
     * Attach order by
     *
     * @param string $slug
     */
    protected function filterSort(string $slug)
    {
        if (array_key_exists($slug, $this->sorts)) {
            $this->query->orderBy(
                DB::raw($this->sorts[$slug]['column']),
                $this->sorts[$slug]['direction']
            );
            $this->currentSortType = self::CUSTOM_SEARCH;
        }
    }

    /**
     * Limiting the display of the number of elements on the page
     *
     * @param int $value
     */
    protected function filterNumbers(int $value)
    {
        if (in_array($value, $this->numbers)) {
            $this->currentLimitPage = $value;
        }
    }

    /**
     * Search by text
     *
     * @param string $text
     */
    protected function filterText(string $text)
    {
        $this->query->where(DB::raw('LOWER(name)'), 'like', '%' . mb_strtolower($text, 'UTF-8') . '%');

        $this->defaultSortType = self::DEFAULT_COURSE_SEARCH_SORT;
    }

    /**
     * Search by period
     *
     * @param string $month
     */
    protected function filterPeriod(string $month)
    {
        $this->query->whereBetween('start_date', [$month, date('Y-m', strtotime($month)).'-31']);
    }

    /**
     * Search by teacher
     *
     * @param int $teacherId
     */
    protected function filterTeacher(int $teacherId)
    {
        $this->query->whereHas('teachers', function (Builder $query) use ($teacherId) {
            return $query->where(function ($query) use ($teacherId) {
                return $query->where('teacher_id', $teacherId);
            });
        });
    }

    /**
     * Add filter by categories ids
     *
     * @param array $ids
     */
    protected function attachCategoriesIds(array $ids)
    {
        $this->query->whereIn('category_id', $ids);
    }

    /**
     * Get function name
     *
     * @param string $key
     * @return string
     */
    protected function getFunctionName(string $key)
    {
        return Str::camel('filter' . Str::ucfirst($key));
    }
}
