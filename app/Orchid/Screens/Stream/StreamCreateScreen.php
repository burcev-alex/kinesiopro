<?php

namespace App\Orchid\Screens\Stream;

use App\Domains\Stream\Models\Stream;
use App\Domains\Stream\Services\StreamOrchidService;
use App\Orchid\Layouts\Stream\StreamSeoRows;
use App\Orchid\Layouts\Stream\StreamImagesRows;
use App\Orchid\Layouts\Stream\StreamMainRows;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class StreamCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Видео-курс';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Добавить видео-курс';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Stream $stream)
    {
        $this->exists = $stream->exists;
        return [
            'stream' => collect([]),
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
                'Основное' => [
                    StreamMainRows::class
                ],
                'Изображение' => [
                    StreamImagesRows::class
                ],
                'SEO' => [
                    StreamSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Stream $stream,
        Request $request,
        StreamOrchidService $service
    )
    {
        $service->setModel($stream);
        $validate = $request->validate([
            'stream.title' => 'required',
            'stream.slug' => 'required',
            'stream.attachment_id' => 'required',
            'stream.*' => ''
        ]);
        $service->save($validate['stream']);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.stream.edit', $stream->id);
    }
}
