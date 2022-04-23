<?php
namespace App\Orchid\Layouts\Stream;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StreamListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'streams';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),

            TD::make('title', 'Название')->render(function ($stream) {
                return Link::make($stream->title)->route('platform.stream.edit', $stream);
            }),
            
            TD::make('active', 'Активность')->render(function ($teacher) {
                return $teacher->active ? 'да' : '<b>нет</b>';
            }),
        ];
    }
}
