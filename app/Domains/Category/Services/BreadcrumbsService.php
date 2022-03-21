<?php
namespace App\Domains\Category\Services;

use App\Domains\Category\Models\Category;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{

    public static function categories()
    {
        Breadcrumbs::for(
            'catalog.categories', 
            function (Trail $trail)
            {
                $trail->push(__('breadcrumbs.catalog'), route('catalog.categories')); 
            }
        );
    }

    /**
     * Хлебные крошки для категорий каталога товаров
     *
     * @return void
     */
    public static function category($category1, $filters)
    {
        
        $arrSlugCategory = [$category1];
        $categories = Category::whereIn('slug', $arrSlugCategory)->where('active', 1)->get();
        
        $arrCategories = [];
       
        foreach($categories as $category){
            $arrCategories[$category->slug] = $category;
        }
        
        Breadcrumbs::for(
            'catalog.category',
            function (Trail $trail) use($category1, $filters, $arrCategories) {

                $trail->push(__('breadcrumbs.catalog'), route('catalog.categories')."/");
                
                if (strlen($category1) > 0) {
                    
                    if(array_key_exists($category1, $arrCategories)){
                        $categoryTitle1 = $arrCategories[$category1]->name;
                    }
                    else{
                        $categoryTitle1 = $category1;
                    }

                    $trail->push($categoryTitle1, route('catalog.category', [$category1])."/");
                }
            }
        );
    }
}
