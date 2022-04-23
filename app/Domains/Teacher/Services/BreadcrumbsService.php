<?php
namespace App\Domains\Teacher\Services;

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки преподавателя
     *
     * @return void
     */
    public static function card($item)
    {
        Breadcrumbs::for(
            'teacher.single',
            function (Trail $trail) use ($item) {
                $trail->push('Преподаватели', route('teacher.index'));

                $trail->push($item->title, route('teacher.single', ['slug' => $item->slug]));
            }
        );
    }
}
