<?php
namespace App\Orchid\Layouts\Banner;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BannersListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'banners';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),

            TD::make('image', 'изображение')->render(function ($banner) {
                return view('platform.banner-image', [
                    'banner_name' => $banner->name,
                    'image' => isset($banner->attachment) ? $banner->attachment->url() : '',
                    'link' => route('platform.banners.edit', ['banners' => $banner->id])
                ]);
            }),
            
            TD::make('active', 'Активность')->render(function ($banner) {
                return $banner->active ? 'да' : '<b>нет</b>';
            }),
        ];
    }
}
