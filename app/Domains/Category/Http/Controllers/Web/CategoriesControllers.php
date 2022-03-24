<?php
namespace App\Domains\Category\Http\Controllers\Web;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Services\BreadcrumbsService;
use App\Domains\Category\Services\CatalogFilterGeneratorService;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Controller;
use App\Services\RouterService;
use App\Domains\Category\Services\CatalogFilterService;

class CategoriesControllers extends Controller {
    protected CatalogFilterService $catalogFilterService;
    protected CatalogFilterGeneratorService $filterGeneratorService;
    protected RouterService $routerService;

    
    public function __construct(
        CatalogFilterService $catalogFilterService,
        CatalogFilterGeneratorService $filterGeneratorService,
        RouterService $routerService)
    {
        $this->routerService = $routerService;
        $this->filterGeneratorService = $filterGeneratorService;
        $this->catalogFilterService = $catalogFilterService;
    }

    public function index(string $param1 = '', string $param4 = '', string $param5 = '')
    {
       
        list($category1, $filters, $page) = $this->routerService->detectParameters([$param1, $param4, $param5]);
        
        $catalog = $this->catalogFilterService->setCategories($category1)
            ->getCatalog($filters, $page);
         
        $pagination = $this->routerService->getPagination($catalog->currentPage(), $catalog->lastPage());
        
        
        // Хлебные крошки
        BreadcrumbsService::category($category1, $filters); 

        // данные для мета тегов, и seo текст
        $arParseFilters = $this->catalogFilterService->parseFilters($filters);
        
        if(array_key_exists('text', $arParseFilters)){
            $typePage = 'search';
        }
        $paths = explode('/', request()->path());
        $targetUrl = request()->path();

        $category_info = $this->catalogFilterService->getCategoryInfo();
        
        if(!$category_info && strlen($category1) > 0){
            abort(404);
        }
        
        $seo = [];

        if(!empty($category_info) && $category_info->meta_title){
            $seo['title'] = $category_info->meta_title;
        } else {
            $seo['title'] = $category_info->name;
        }

        if(!empty($category_info) && $category_info->meta_description){
            $seo['description'] = $category_info->meta_description;
        } else {
            $seo['description'] = '';
        }

        if(!empty($category_info) && $category_info->meta_keywords){
            $seo['keywords'] = $category_info->meta_keywords;
        } else {
            $seo['keywords'] = '';
        }

        if(!empty($category_info) && $category_info->attachment){
            $seo['image'] = $category_info->attachment->url;
        } else {
            $seo['image'] = '';
        }
        

        if (request()->wantsJson()) {
            $filterSchema = $this->filterGeneratorService->getFilterSchema();

            $templateCatalogList = 'includes.catalog.catalog-list';
            $paginationBlock = 'catalog-page-block';

            return response()->json([

                'filters' => [
                    'data' => $filterSchema
                ],
                'resource' => [
                    'html' => view($templateCatalogList, ['products' => $catalog])->render(),
                    'data' => $catalog
                ],
                'pagination' => [
                    'html' => view('includes.pagination', ['pagination' => $pagination, 'block' => $paginationBlock])->render(),
                    'data' => $pagination
                ],
                'selectedCourses' => $catalog->total(),
                'totalCourses' => $this->catalogFilterService->gettotalCourses(),
                'isFavorite' => $this->catalogFilterService->isFavorite()
            ]);
        } else {
            return view('pages.categories.catalog', [
                'targetUrl' => $targetUrl,
                'seo' => $seo,
                //'canonical' => $this->canonicalService->render(),
                'courses' => $catalog,
                'categoryInfo' => $seo,
                'pagination' => $pagination,
                'selectedCourses' => $catalog->total(),
                'totalCourses' => $this->catalogFilterService->gettotalCourses(),
                'isFavorite' => $this->catalogFilterService->isFavorite()
            ]);
        }

    }

    /**
     * Get filters
     */
    public function filters() {

        return response()->json([
            'filters' => $this->filterGeneratorService->getFilterSchema(),
            'total' => [
                'general' => $general = $this->filterGeneratorService->gettotalCourses(),
                'selected' => $selected = $this->filterGeneratorService->getSelectedCountProducts(),
                'text' => trans_choice('filter.diapazon', $selected, ['value' => $selected, 'count' => $general])
            ]
        ]);
    }
}