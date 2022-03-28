<?php

namespace App\Domains\Category\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Services\CourseService;
use App\Domains\Teacher\Models\Teacher;
use App\Domains\Teacher\Services\TeachersService;
use App\Services\RouterService;
use Illuminate\Support\Carbon;

class CatalogFilterGeneratorService extends AbstractCatalogFilterService
{
    protected array $sorts = [
        [
            'title' => 'filter.sort.option0',
            'title_select' => 'filter.sort.option_select0',
            'class' => 'first',
            'slug' => 'sort'
        ],
        [
            'title' => 'filter.sort.option1',
            'title_select' => 'filter.sort.option_select1',
            'class' => 'arr-up',
            'slug' => 'min_price'
        ],
        [
            'title' => 'filter.sort.option2',
            'title_select' => 'filter.sort.option_select2',
            'class' => 'arr-down',
            'slug' => 'max_price'
        ],
        [
            'title' => 'filter.sort.option3',
            'title_select' => 'filter.sort.option_select3',
            'class' => '',
            'slug' => 'date'
        ],
        
    ];

    protected array $numbers = [
        [
            'title' => 'filter.numbers.option1',
            'slug' => '15'
        ],
        [
            'title' => 'filter.numbers.option2',
            'slug' => '30'
        ],
        [
            'title' => 'filter.numbers.option3',
            'slug' => '60'
        ],
        [
            'title' => 'filter.numbers.option4',
            'slug' => '120'
        ],
    ];

    protected array $filters;

    protected CourseService $courseService;
    protected RouterService $routerService;
    protected array $selectedFilters = [];
    /** @var int Contain count of selected filters */
    protected int $selectedCount = 0;

    public function __construct(RouterService $routerService, CourseService $courseService)
    {
        $this->courseService = $courseService;
        $this->routerService = $routerService;
        
        $this->selectedFilters = $this->parseFilters(
            $routerService->detectFiltersFromPath()
        );

        $this->filters = RefChar::select('slug')->get()->toArray();

        parent::__construct();
    }

    /**
     * @return array
     */
    public function getFilterSchema(): array
    {
        $baseFilters = $this->getGeneralFilters();

        $baseFilters['teachers'] = [
            'id' => 0,
            'title' => 'Преподаватели',
            'options' => $this->getTeachers()
        ];
        $baseFilters['periods'] = [
            'id' => 0,
            'title' => 'Период',
            'options' => $this->getPeriods()
        ];
        
        return [
            'sub_category' => $this->getSubCategory(),
            'sort' => $this->getSort(),
            'numbers' => $this->getNumbers(),
            'filters' =>  $baseFilters,
            'selected_count' => $this->selectedCount
        ];
    }

    /**
     * @return array
     */
    public function getSort(): array
    {
        // translate
        foreach ($this->sorts as &$sort) {
            $sort['title'] = __($sort['title']);
            $sort['title_select'] = __($sort['title_select']);
        }

        $selected = $this->sorts[0];

        if (isset($this->selectedFilters['sort'])) {
            foreach ($this->sorts as $order) {
                if ($order['slug'] == $this->selectedFilters['sort']) {
                    $selected = $order;
                    break;
                }
            }
        }

        return [
            'selected' => $selected,
            'options' => $this->sorts
        ];
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        // translate
        foreach ($this->numbers as &$sort) {
            $sort['title'] = __($sort['title']);
        }

        $selected = $this->numbers[0];

        if (isset($this->selectedFilters['numbers'])) {
            foreach ($this->numbers as $order) {
                if ($order['slug'] == $this->selectedFilters['numbers']) {
                    $selected = $order;
                    break;
                }
            }
        }

        return [
            'selected' => $selected,
            'options' => $this->numbers
        ];
    }

    /**
     * @return array
     */
    public function getTeachers(): array
    {
        $selected = '';

        $teacherIds = Course::where('marker_archive', 0)->where('active', 1)->with('teachers')->get()->map(function($item){
            if($item->teachers->count() > 0){
                return $item->teachers->map(function($teacher){
                    return $teacher->id;
                });
            }
            else{
                return 0;
            }
        })->toArray();
        $arr = array_unique(array_merge(...$teacherIds));
        foreach($arr as &$val){
            $val = intval($val);
        }
        unset($val);

        $teachers = Teacher::whereIn('id', $arr)->get();

        return $teachers->toArray();
    }

    /**
     * @return array
     */
    public function getPeriods(): array
    {
        $date_m = array('Null', 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');


        $selected = '';

        $courses = Course::where('marker_archive', 0)->where('active', 1)->select(['start_date'])->groupBy('start_date')->get();
        
        $list = [];
        foreach($courses as $course){
            $list[] = [
                'value' => $course->start_date->format('Y-m').'-01',
                'title' => $date_m[$course->start_date->format('n')].' '.$course->start_date->format('Y')
            ];
        }

        return $list;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getGeneralFilters(): array
    {
        list($chars, $aggregationValues) = $this->updateCharsDependsOnCourses($this->refCharService->getCharsGroupedBySlug());
        $return = [];

        foreach ($this->filters as $filter) {
            
            $char = $chars[$filter['slug']] ?? null;
            if (!$char) {
                continue;
            }

            $filter['id'] = $char['id'];
            $filter['title'] = $char['name'];
            
            $options = [];
            foreach ($char['values'] ?? [] as $item) {
                if (isset($item['available'])) {
                    if (!isset($options[$item['slug']])) {

                        $options[$item['slug']] = [
                            'id' => $item['id'],
                            'title' => $item['value'],
                            'value' => $item['slug'],
                            'available' => $item['available']
                        ];
                    } elseif (!$options[$item['slug']]['available'] && $item['available']) {
                        $options[$item['slug']]['available'] = $item['available'];
                    }
                }
            }
            
            uasort($options, function($v1, $v2){
                if ($v1['value'] < $v2['value']) {
                    return -1;
                } elseif ($v1['value'] > $v2['value']) {
                    return 1;
                } else {
                    return strcmp($v1['value'], $v2['value']);
                }
            });

            $filter['options'] = array_values($options);

            

            $return[$filter['slug']] = $this->markSelectedFilter($filter);
            
        }

        return $return;
    }

    /**
     * Filter chars by set category from the path
     * @param array $chars
     * @return array
     * @throws \Exception
     */
    public function updateCharsDependsOnCourses(array $chars): array
    {
        // Установить фильтра в продукты и получить по них свойства для отображения
        $filterService = new CatalogFilterService();

        $array = array_values(array_filter(explode('/', request()->path()), function ($value) {
            return $value && !in_array($value, ['catalog', 'filters']);
        }));

        list($category1, $filters) = $this->routerService->detectParameters($array);
        
        $rs = $filterService->setCategories($category1);
        list($properties, $propertiesByCategories, $aggregationValues) = $filterService->getAvailableProperties($filters);

        $this->totalCourses = $filterService->getTotalCourses();
        $this->selectedProducts = $filterService->getSelectedCountCourses();
        
        $return = [];
        foreach ($chars as $slug => $char) {
            // Если доступно для категории то включить фильтр
            if (!empty($propertiesByCategories[$char['id']])) {
                $availableValueIds = $properties[$char['id']] ?? [];
                $categoryValues = $propertiesByCategories[$char['id']];
                foreach ($char['values'] as &$value) {
                    if (in_array($value['id'], $categoryValues)) {
                        // Доступен ли значение фильтра
                        $value['available'] = in_array($value['id'], $availableValueIds);
                    }
                }
                $return[$slug] = $char;
            }
        }

        return [$return, $aggregationValues];
    }

    /**
     * Mark filters as selected
     * @param array $filter
     * @param string $type
     * @return array
     */
    public function markSelectedFilter(array $filter, string $type = 'default')
    {
        $selectedOptions = $this->selectedFilters[$filter['slug']] ?? [];

        if ($type == 'between') {
            foreach ($filter['options'] as $key => &$option) {
                if (isset($selectedOptions[$key])) {
                    $option['selected'] = $selectedOptions[$key];
                    // Mark general filter
                    $filter['selected'] = true;
                    $this->selectedCount += 1;
                } else {
                    // Mark general filter
                    $filter['selected'] = $filter['selected'] ?? false;
                    $option['selected'] = null;
                }
            }
        } else {
            foreach ($filter['options'] as &$option) {
                $option['selected'] = in_array($option['value'], $selectedOptions);
                if ($option['selected']) {
                    $option['available'] = true;

                    // Mark general filter
                    $filter['selected'] = true;
                    $this->selectedCount += 1;
                }
            }
        }

        return $filter;
    }

    /**
     * @return array
     */
    public function getSubCategory(){

        $categories = Category::where('active', 1)->with('attachment')->get()->toArray();
        
        return $categories;
    }
}
