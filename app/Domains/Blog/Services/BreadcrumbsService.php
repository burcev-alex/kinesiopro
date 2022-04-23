<?php
namespace App\Domains\Blog\Services;

use App\Domains\Blog\Models\Category;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки товара
     *
     * @return void
     */
    public static function card($paper)
    {
        Breadcrumbs::for(
            'blog.single',
            function (Trail $trail) use ($paper) {
                $trail->push('Блог', route('blog'));

                $trail->push($paper->title, route('blog.single', ['slug' => $paper->slug]));
            }
        );
    }
}
