<?php


namespace App\Orchid\Screens\Currency;


use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\Services\CurrenciesService;
use App\Orchid\Layouts\Currency\СurrenciesMainRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CurrenciesCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Валюты';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Создание валюты';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Currency $currency): array
    {
        $this->exists = $currency->exists;

        return [
            'currencies' => collect([])
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
                    СurrenciesMainRows::class
                ]
            ])
        ];
    }

    public function save(
        Currency $currency,
        Request $request,
        CurrenciesService $service
    )
    {
        $service->setModel($currency);
        $validate = $request->validate([
            'currencies.code' => 'required',
            
            'currencies.*' => ''
        ]);

        $service->save($validate);


        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.currencies.edit', $currency);

    }
}
