<?php


namespace App\Orchid\Screens\Banner;


use App\Domains\Banner\Models\Banner;
use App\Orchid\Layouts\Banner\BannersListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class BannersListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Баннеры';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех баннеров';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'banners' => Banner::orderBy('id', 'ASC')->paginate(12)
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
                ->route('platform.banners.create'),
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
            BannersListLayout::class
        ];
    }
}
