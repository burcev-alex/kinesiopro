<?php


namespace App\Orchid\Screens\Stream;

use App\Domains\Stream\Models\Stream;
use App\Orchid\Layouts\Stream\StreamListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class StreamListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Видео-курсы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех видео-курсов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'streams' => Stream::orderBy('id', 'ASC')->paginate(12),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.stream.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            StreamListLayout::class
        ];
    }
}
