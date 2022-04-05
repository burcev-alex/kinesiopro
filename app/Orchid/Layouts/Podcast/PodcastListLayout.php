<?php
namespace App\Orchid\Layouts\Podcast;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PodcastListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'podcasts';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', 'Название'),
            TD::make('active', 'Активность')->render(function ($podcast) {
                return $podcast->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('slug', 'Символьный код')->render(function ($podcast) {
                return Link::make($podcast->slug)->route('platform.podcast.edit', $podcast);
            }),

        ];
    }
}
