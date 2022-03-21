<?php
namespace App\Domains\Course\Http\Controllers\Web;

use App\Domains\Course\Models\Course;
use App\Domains\Course\Services\BreadcrumbsService;
use App\Domains\Course\Services\CoursePropertiesService;
use App\Domains\Course\Services\CourseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use function Symfony\Component\String\b;

class CardControllers extends Controller {

    protected CourseService $productService;
    protected CoursePropertiesService $productPropertiesService;

    /**
     * @param CourseService $productService
     * @param CoursePropertiesService $productPropertiesService
     */
    public function __construct(CourseService $productService, CoursePropertiesService $productPropertiesService)
   //public function __construct(CourseService $productService)
    {
        $this->productService = $productService;
        $this->productPropertiesService = $productPropertiesService;
    }

    /**
     * Get product by id
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug) {
              
        /** @var Course $product */
        $product = $this->productService->show($slug);
        
        if (!$product) {
            abort(404);
        }

        // Хлебные крошки
        BreadcrumbsService::card($product);

        $seo = [
            'product' => [
                'availability' => $product->marker_archive ? 'discontinued' : 'in stock',
                'title' => $product->name,
                'link' => route('products.card', ['slug' => $product->slug]),
                'price' => $product->marker_archive ? "0 RUB" : round($product->variant->price * $product->variant->currency->value, 2)." RUB",
                'condition' => $product->marker_archive ? '' : 'new',
                'currency' => 'RUB',
                'brand' => 'Kinesiopro',
            ]
        ];

        if(!empty($product) && $product->meta_h1){
            $seo['h1'] = $product->meta_h1;
        } else {
            $seo['h1'] = $product->name;
        }

        if(!empty($product) && $product->meta_title){
            $seo['title'] = $product->meta_title;
        } else {
            $seo['title'] = $product->name;
        }

        if(!empty($product) && $product->meta_description){
            $seo['description'] = $product->meta_description;
        } else {
            $seo['description'] = $product->name;
        }

        if(!empty($product) && $product->meta_keywords){
            $seo['keywords'] = $product->meta_keywords;
        } else {
            $seo['keywords'] = '';
        }
        
        return view('pages.product.card', [
            'seo' => $seo,
            'product' => $product,
            'generalProperties' => $this->productPropertiesService->getGeneralProperties($product),
            'fullProperties' => $this->productPropertiesService->getFullListDescription($product),
        ]);
    }
}
