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
                $trail->push('Видеокурсы', route('stream.index'));

                $trail->push($stream->title, route('stream.single', ['slug' => $stream->slug]));
            }
        );
    }

    /**
     * Хлебные крошки для урока видео курса
     *
     * @return void
     */
    public static function lesson($stream, $lesson)
    {
        Breadcrumbs::for(
            'stream.single.lesson',
            function (Trail $trail) use ($stream, $lesson) {
                $trail->push('Видеокурсы', route('stream.index'));

                $trail->push($stream->title, route('stream.single', ['slug' => $stream->slug]));

                $trail->push($stream->title, route('stream.single.lesson', [
                    'stream' => $stream->slug,
                    'lessonId' => $lesson->id,
                ]));
            }
        );
    }
}
