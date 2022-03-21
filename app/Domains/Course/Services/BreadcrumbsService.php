<?php
namespace App\Domains\Course\Services;

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
        Breadcrumbs::for(
            'catalog.card',
            function (Trail $trail) use($product) {
                $trail->push(__('breadcrumbs.catalog'), route('catalog.categories'));
               

                if ($product->category) {
                    $params = [];
                    $params[] = $product->category->slug;

                    $trail->push($product->category->name, route('catalog.category', $params)."/");
                }

                $trail->push($product->name, route('catalog.card', ['slug' => $product->slug]));
            }
        );
    }
}
