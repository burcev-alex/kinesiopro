<?php

namespace App\Domains\Category\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Services\CourseService;
use App\Services\RouterService;

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

    protected CourseService $CourseService;
    protected RouterService $routerService;
    protected array $selectedFilters = [];
    /** @var int Contain count of selected filters */
    protected int $selectedCount = 0;

    public function __construct(RouterService $routerService, CourseService $CourseService)
    {
        $this->CourseService = $CourseService;
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
        
        return [
            'sub_category' => $this->getSubCategory(),
            'totalCourses' => $this->CourseService->getTotalActiveProducts(),
            'sort' => $this->getSort(),
            'numbers' => $this->getNumbers(),
            'type' => $this->getTypeFilter(),
            'filters' =>  $this->getGeneralFilters(),
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
     * @throws \Exception
     */
    public function getGeneralFilters(): array
    {
        list($chars, $aggregationValues) = $this->updateCharsDependsOnProducts($this->refCharService->getCharsGroupedBySlug());
        $return = [];
        foreach ($this->filters as $filter) {
            
            $char = $chars[$filter['slug']] ?? null;
            if (!$char) {
                continue;
            }

            $filter['id'] = $char['id'];
            $filter['title'] = $char['translation']['name'];

            
            $options = [];
            foreach ($char['values'] ?? [] as $item) {
                if (isset($item['available'])) {
                    if (!isset($options[$item['slug']])) {
                        $countOverlap = 0;
                        if(
                            count($aggregationValues) > 0 && 
                            array_key_exists($char['slug'], $aggregationValues) && 
                            array_key_exists($item['slug'], $aggregationValues[$char['slug']])
                            ){
                            $countOverlap = $aggregationValues[$char['slug']][$item['slug']];
                        }

                        $options[$item['slug']] = [
                            'id' => $item['id'],
                            'title' => $item['value'].(IntVal($countOverlap) > 0 ? " (".$countOverlap.")" : ""),
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
            
        }

        return $return;
    }

    /**
     * Filter chars by set category from the path
     * @param array $chars
     * @return array
     * @throws \Exception
     */
    public function updateCharsDependsOnProducts(array $chars): array
    {
        // Установить фильтра в продукты и получить по них свойства для отображения
        $filterService = new CatalogFilterService();

        $array = array_values(array_filter(explode('/', request()->path()), function ($value) {
            return $value && !in_array($value, ['catalog', 'filters']);
        }));

        list($category1, $filters) = $this->routerService->detectParameters($array);
        
        $rs = $filterService->setCategories($category1);
        list($properties, $propertiesByCategories, $aggregationValues) = $filterService->getAvailableProperties($filters);

        $this->totalCourses = $filterService->gettotalCourses();
        $this->selectedProducts = $filterService->getSelectedCountProducts();
        
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
        // первое выбранное поле в фильтре
        if (array_key_exists('start', $this->selectedFilters)) {
            $firstSelectedField = implode('', $this->selectedFilters['start']);
        }
        else{
            $firstSelectedField = '';
        }

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

            // если выбрано значение первого свойства, все остальные этого же свойства 
            // должны быть доступны к выборке
            if($firstSelectedField == $filter['slug'] && array_key_exists('selected', $filter) && $filter['selected']){
                foreach ($filter['options'] as $key => &$option) {
                    $option['available'] = true;
                }
                unset($option);
            }
        }

        return $filter;
    }

    /**
     * @return array
     */
    public function getSubCategory(){

        $categories = [];
        
        return $categories;
    }
}
