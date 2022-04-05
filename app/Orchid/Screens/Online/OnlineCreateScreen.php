<?php
namespace App\Orchid\Screens\Online;

use App\Domains\Online\Http\Requests\OrchidOnlineRequest;
use App\Domains\Online\Models\Online;
use App\Domains\Online\Services\OnlineOrchidService;
use App\Orchid\Layouts\Online\OnlinePreviewRows;
use App\Orchid\Layouts\Online\OnlineMainRows;
use App\Orchid\Layouts\Online\OnlineSeoRows;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OnlineCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создать онлайн-курс';
    public $description = 'Карточка создания нового онлайн-курса';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Назад')
                 ->href(route('platform.online.list'))
                 ->icon('undo'),
            
            Button::make('Сохранить')
                ->method('save')
                ->icon('save'),
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
                'Курс' => [
                    OnlineMainRows::class
                ],
                'Краткое описание' => [
                    OnlinePreviewRows::class
                ],
                'SEO' => [
                    OnlineSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Online $online,
        OrchidOnlineRequest $request,
        OnlineOrchidService $service
    )
    {

        $service->setModel($online);
        $validated = $request->validated();

        $service->save($validated['online']);

        if (array_key_exists('images', $validated)) {
            $service->saveImages($validated['images']);
        }
       
        Alert::success('Курс успешно создан');
        return redirect()->route('platform.online.edit', $online);
    }
}
