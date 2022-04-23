<?php

namespace App\Orchid\Screens\Utils;

use App\Orchid\Layouts\Examples\MetricsExample;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Artisan;

class ClearCacheScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Сброс кешей';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Предоставляется возможнонсть сбросить кеш config, view, data';

    /**
     * Query data.
     *
     * @return array
     */
    public function query() : array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar() : array
    {
        return [];
    }

    /**
     * Views.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function layout() : array
    {
        return [
            Layout::rows([
                Button::make('Кеш конфигурации')
                ->method('clear_config')
                ->novalidate()
                ->icon('icon-bag'),
                Button::make('Кеш шаблонов')
                ->method('clear_view')
                ->novalidate()
                ->icon('icon-bag'),
                Button::make('Кеш данных')
                ->method('clear_data')
                ->novalidate()
                ->icon('icon-bag'),
            ]),
        ];
    }

    /**
     * Clear data
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear_data(Request $request)
    {
        Artisan::call('cache:clear');

        Toast::warning($request->get('toast', 'Кеш данных сброшен'));

        return back();
    }

    /**
     * Clear view
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear_view(Request $request)
    {
        Artisan::call('view:clear');

        Toast::warning($request->get('toast', 'Кеш шаблонов сброшен'));

        return back();
    }

    /**
     * Clear config
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear_config(Request $request)
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        Toast::warning($request->get('toast', 'Кеш конфигурации сброшен'));

        return back();
    }
}
