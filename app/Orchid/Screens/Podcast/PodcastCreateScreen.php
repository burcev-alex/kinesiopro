<?php

namespace App\Orchid\Screens\Podcast;

use App\Domains\Podcast\Models\Podcast;
use App\Domains\Podcast\Services\PodcastService;
use App\Orchid\Layouts\Podcast\PodcastMainRows;
use App\Orchid\Layouts\Podcast\PodcastSeoRows;
use App\Orchid\Layouts\Podcast\PodcastShortRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PodcastCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = '';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Создание подкаста';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Podcast $podcast): array
    {
        $this->exists = $podcast->exists;

        return [
            'podcast' => collect([]),
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
            Button::make('Сохранить')
                ->method('save')->icon('save')
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
            Layout::tabs([
                'Подкаст' => [
                    PodcastMainRows::class
                ],
                'Описание' => [
                    PodcastShortRows::class
                ],
                'SEO' => [
                    PodcastSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Podcast $podcast,
        Request $request,
        PodcastService $service
    )
    {
        $service->setModel($podcast);
        $validate = $request->validate([
            'podcast.title' => 'required',
            'podcast.slug' => 'required',
            'podcast.url' => 'required',
            'podcast.attachment_id' => 'required',
            'podcast.*' => ''
        ]);

        $service->save($validate['podcast']);

        Cache::tags(['podcasts'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.podcast.edit', $podcast);
    }
}
