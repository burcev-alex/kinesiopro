<?php
namespace App\Domains\Product\Services;

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки товара
     *
     * @return void
     */
    public static function card($product)
    {
        // Breadcrumbs::for(
        //     'products.card',
        //     function (Trail $trail) use($product) {
        //         //$trail->push('Каталог', route('products.catalog'));
        //         $trail->push('Каталог', '/catalogs');
               
        //         if ($product->categoryMain->category->parent && $product->categoryMain->category->parent->parent) {
        //             $trail->push($product->categoryMain->category->parent->parent->name, route('products.catalog', [$product->categoryMain->category->parent->parent->slug]));
        //         }
        //         if ($product->categoryMain->category && $product->categoryMain->category->parent) {
        //             $params = [];
        //             if ($product->categoryMain->category->parent->parent) {
        //                 $params[] = $product->categoryMain->category->parent->parent->slug;
        //             }
        //             $params[] = $product->categoryMain->category->parent->slug;
        //             $trail->push($product->categoryMain->category->parent->name, route('products.catalog', $params));
        //         }
        //         if ($product->categoryMain->category) {
        //             $params = [];
        //             if ($product->categoryMain->category->parent && $product->categoryMain->category->parent->parent) {
        //                 $params[] = $product->categoryMain->category->parent->parent->slug;
        //             }
        //             if ($product->categoryMain->category->parent) {
        //                 $params[] = $product->categoryMain->category->parent->slug;
        //             }
        //             $params[] = $product->categoryMain->category->slug;

        //             $trail->push($product->categoryMain->category->name, route('products.catalog', $params));
        //         }

        //         $trail->push($product->name, route('products.card', ['slug' => $product->slug]));
        //     }
        // );



        Breadcrumbs::for(
            'products.card',
            function (Trail $trail) use($product) {
                $trail->push(__('breadcrumbs.catalog'), route('categories.categories'));
                
                if ($product->categoryMain && $product->categoryMain->category->parent && $product->categoryMain->category->parent->parent) {
                    $trail->push($product->categoryMain->category->parent->parent->name, '/categories');
                }
                if ($product->categoryMain && $product->categoryMain->category && $product->categoryMain->category->parent) {
                    $params = [];
                    if ($product->categoryMain->category->parent->parent) {
                        $params[] = $product->categoryMain->category->parent->parent->slug;
                    }
                    $params[] = $product->categoryMain->category->parent->slug;

                    $trail->push($product->categoryMain->category->parent->name, route('categories.category', $params)."/");
                }
               

                if ($product->categoryMain && $product->categoryMain->category) {
                    $params = [];
                    if ($product->categoryMain->category->parent) {
                        $params[] = $product->categoryMain->category->parent->slug;
                    }
                    
                    if ($product->categoryMain->category->parent && $product->categoryMain->category->parent->parent) {
                        $params[] = $product->categoryMain->category->parent->parent->slug;
                    }
                    
                    $params[] = $product->categoryMain->category->slug;

                    $trail->push($product->categoryMain->category->name, route('categories.category', $params)."/");
                }
                

                $trail->push($product->name, route('products.card', ['slug' => $product->slug]));
            }
        );
    }
}
