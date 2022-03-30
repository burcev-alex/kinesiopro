<?php
namespace App\Domains\Online\Services;

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки подкаста
     *
     * @return void
     */
    public static function card($online)
    {
        Breadcrumbs::for(
            'online.single',
            function (Trail $trail) use($online) {
                $trail->push(__('breadcrumbs.online'), route('online'));

                $trail->push($online->title, route('online.single', ['slug' => $online->slug]));
            }
        );
    }
}
