<?php
namespace App\Domains\Stream\Services;

use App\Domains\Stream\Models\Stream;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

final class BreadcrumbsService
{
    /**
     * Хлебные крошки для детальной карточки видео курса
     *
     * @return void
     */
    public static function card($stream)
    {
        Breadcrumbs::for(
            'stream.single',
            function (Trail $trail) use ($stream) {
                $trail->push('Видео курсы', route('stream'));

                $trail->push($stream->title, route('stream.single', ['slug' => $stream->slug]));
            }
        );
    }
}
