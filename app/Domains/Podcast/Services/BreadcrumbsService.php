<?php
namespace App\Domains\Podcast\Services;

use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки подкаста
     *
     * @return void
     */
    public static function card($podcast)
    {
        Breadcrumbs::for(
            'podcast.single',
            function (Trail $trail) use($podcast) {
                $trail->push(__('breadcrumbs.podcast'), route('podcast'));

                $trail->push($podcast->title, route('podcast.single', ['slug' => $podcast->slug]));
            }
        );
    }
}
