<?php
namespace App\Orchid\Screens\Podcast;

use App\Domains\Podcast\Models\Podcast;
use App\Orchid\Layouts\Podcast\PodcastListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class PodcastListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Подкасты';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех подкастов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'podcasts' => Podcast::paginate(15),
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
                ->route('platform.podcast.create'),
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
            PodcastListLayout::class
        ];
    }
}
