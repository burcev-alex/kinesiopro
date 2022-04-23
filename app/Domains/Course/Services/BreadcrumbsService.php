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
    public static function card($course)
    {
        Breadcrumbs::for(
            'courses.card',
            function (Trail $trail) use ($course) {
                $trail->push(__('breadcrumbs.catalog'), route('courses.index'));
                
                if ($course->category) {
                    $params = [];
                    $params[] = $course->category->slug;

                    $trail->push($course->category->name, route('courses.index', $params)."/");
                }

                $trail->push($course->name, route('courses.card', ['slug' => $course->slug]));
            }
        );
    }
}
