<?php
namespace App\Orchid\Screens\Podcast;

use App\Domains\Podcast\Models\Podcast;
use App\Domains\Podcast\Services\PodcastService;
use App\Orchid\Layouts\Podcast\PodcastMainRows;
use App\Orchid\Layouts\Podcast\PodcastSeoRows;
use App\Orchid\Layouts\Podcast\PodcastShortRows;
use App\Orchid\Layouts\Podcast\SeoTemplateRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\Cache;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class PodcastEditScreen extends Screen
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
    public $description = 'Редактирование подкаста';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Podcast $podcast): array
    {
        $this->exists = $podcast->exists;

        if ($this->exists) {
            $this->description = 'Редактировать подкаста';
            if ($podcast) {
                $this->name = $podcast->title;
            }

            return [
                'podcast' => $podcast,
            ];
        } else {
            return [
                'podcast' => collect([]),
            ];
        }
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
            ->method('save')->icon('save'),

            Button::make('Удалить')
            ->method('remove')->icon('trash'),
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

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.podcast.edit', $podcast);
    }

    /**
     * Remove
     *
     * @param Podcast $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Podcast $podcast)
    {
        $podcast->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.podcast.list');
    }
}
