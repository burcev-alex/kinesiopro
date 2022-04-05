<?php

namespace App\Orchid\Screens\Banner;

use App\Domains\Banner\Models\Banner;
use App\Domains\Banner\Services\BannersService;
use App\Orchid\Layouts\Banner\BannersImagesRows;
use App\Orchid\Layouts\Banner\BannersMainRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class BannersCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Баннер';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Добавить баннер';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Banner $banner)
    {
        $this->exists = $banner->exists;
        return [
            'banner' => collect([]),
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
                    BannersMainRows::class
                ],
                'Изображение' => [
                    BannersImagesRows::class
                ],
            ])
        ];
    }

    public function save(
        Banner $banner,
        Request $request,
        BannersService $service
    )
    {
        $service->setModel($banner);
        $validate = $request->validate([
            'banner.name' => 'required',
            'banner.images' => 'array|min:2|max:2|required',
            'banner.images.attachment_id' => 'array|min:1|max:1|required',
            'banner.images.attachment_mobile_id' => 'array|min:1|max:1|required',
            'banner.*' => ''
        ]);
        $service->save($validate);
        $service->saveImages(isset($validate['banner']['images']) ? $validate['banner']['images'] : []);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.banners.edit', $banner->id);
    }
}
