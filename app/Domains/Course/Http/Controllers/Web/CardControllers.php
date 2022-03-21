<?php
namespace App\Domains\Product\Http\Controllers\Web;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Services\BreadcrumbsService;
use App\Domains\Product\Services\ProductService;
use App\Services\ProductPropertiesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;
use function Symfony\Component\String\b;

class CardControllers extends Controller {

    protected ProductService $productService;
    protected ProductPropertiesService $productPropertiesService;

    /**
     * @param ProductService $productService
     * @param ProductPropertiesService $productPropertiesService
     */
    public function __construct(ProductService $productService, ProductPropertiesService $productPropertiesService)
   //public function __construct(ProductService $productService)
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
              
        /** @var Product $product */
        $product = $this->productService->show($slug);
        
        if (!$product) {
            abort(404);
        }

        // Хлебные крошки

        BreadcrumbsService::card($product);
        
        $properties = $this->productPropertiesService->getCartPropertiesFull($product);
       
        $exp = explode(' ', $product->translation->name);
        $productName = mb_strtolower($exp[0]);
        unset($exp[0]);
        $productName .= ' '.implode(' ', $exp);
        $gen_description = __('product.card.template_model_description_name', [
            'category' => $product->category ? mb_strtolower(trim($product->category->categoryTranslation->name)) : 'none',
            'name' => $productName,
        ]);

        $schema_parents = [
            'cvet'
        ];

      
        foreach ($schema_parents as $schema):
            switch (array_key_exists($schema, $properties) and $properties[$schema]['value']!=''):
                case 'true':
                    $gen_description .= __('product.card.template_model_description_'.$schema, [$schema => mb_strtolower($properties[$schema]['value'])]);
                    break;
            endswitch;
        endforeach;

        if(empty($product->translation->description) || strlen($product->translation->description) < 20){
            $product->translation->description = $gen_description;
        }

        $fullOptions = $this->productPropertiesService->getFullListOptions($product);

        $seo = [
            'image' => $product->image ? $product->image->attachment->url : null,
            'product' => [
                'availability' => $product->marker_archive ? 'discontinued' : 'in stock',
                'title' => $productName,
                'article' => $product->article,
                'link' => route('products.card', ['slug' => $product->slug]),
                'price' => $product->marker_archive ? "0 UAH" : round($product->variant->price * $product->variant->currency->value, 2)." UAH",
                'price_sale' => $product->marker_archive ? "0" : round($product->variant->price_sale * $product->variant->currency->value, 2),
                'price_amount' => $product->marker_archive ? "0" : round($product->variant->price * $product->variant->currency->value, 2),
                'image_link' => $product->image ? $product->image->attachment->url : null,
                'condition' => $product->marker_archive ? '' : 'new',
                'currency' => 'UAH',
                'brand' => 'Экож',
            ]
        ];

        if(!empty($product) && $product->translation->meta_h1){
            $seo['h1'] = $product->translation->meta_h1;
        } else {
            $seo['h1'] = $product->translation->name;
        }

        if(!empty($product) && $product->translation->meta_title){
            $seo['title'] = $product->translation->meta_title;
        } else {
            $seo['title'] = __('product.card.meta_title', [
                'price' => round($product->variant->price * $product->variant->currency->value, 2),
                'name' => $productName,
            ]);
        }

        if(!empty($product) && $product->translation->meta_description){
            $seo['description'] = $product->translation->meta_description;
        } else {
            $seo['description'] = __('product.card.meta_description', [
                'name' => $productName,
            ]);
        }

        if(!empty($product) && $product->translation->meta_keywords){
            $seo['keywords'] = $product->translation->meta_keywords;
        } else {
            $seo['keywords'] = '';
        }
        
        return view('pages.product.card', [
            'seo' => $seo,
            'product' => $product,
            'generalProperties' => $this->productPropertiesService->getGeneralProperties($product),
            'fullOptions' => $fullOptions,
            'fullProperties' => $this->productPropertiesService->getFullListDescription($product),
            'similarProducts' => $this->productService->getSimilarProductsByCategoryId($product->id ,$product->categories, 10)
        ]);
    }
}
