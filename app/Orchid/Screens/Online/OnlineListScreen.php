<?php


namespace App\Orchid\Screens\Online;

use App\Domains\Online\Models\Online;
use App\Orchid\Layouts\Online\OnlineListLayout;
use App\Orchid\Screens\Filters\OnlineFiltersLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class OnlineListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Онлайн-курсы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех онлайн-курсов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $filter = OnlineFiltersLayout::class;
        
        return [
            'onlines' => Online::filters()->filtersApplySelection($filter)->orderBy('id', 'DESC')->paginate(10),
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
            Link::make('Создать онлайн-курс')->icon('pencil')->route('platform.online.create')
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
            OnlineFiltersLayout::class,
            OnlineListLayout::class,
        ];
    }
}
