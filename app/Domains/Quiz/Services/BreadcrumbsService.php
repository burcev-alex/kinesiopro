<?php
namespace App\Domains\Quiz\Services;

use App\Domains\Blog\Models\Category;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки теста
     *
     * @return void
     */
    public static function card($item)
    {
        Breadcrumbs::for(
            'tests.single',
            function (Trail $trail) use($item) {
                $trail->push('Тесты', route('tests'));

                $trail->push($item->title, route('tests.single', ['slug' => $item->slug]));
            }
        );
    }
}
