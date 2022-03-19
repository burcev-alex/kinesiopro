<?php


namespace App\Orchid\Screens\Currency;

use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\Services\CurrenciesService;
use App\Orchid\Layouts\Currency\СurrenciesMainRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CurrenciesEditScreen extends Screen
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
    public $description = 'Редактирование валюты';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Currency $currency){
        $this->exists = $currency->exists;
        if ($this->exists) {
            $this->description = 'Редактировать валюты';
            if ($currency) {
                $this->name = $currency->name;
            }

            return [
                'currencies' => $currency
            ];
        }
        else{
            return [
                'currencies' => collect([])
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
                ->method('remove')->icon('trash')
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
    ){
        $service->setModel($currency);
        $validate = $request->validate([
            'currencies.code' => 'required',
            'currencies.name' =>'required',
            'currencies.value' =>'required',
            'currencies.*' => ''
        ]);
        $service->save($validate);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.currencies.edit', $currency);
    }

    /**
     * @param Currency $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Currency $currency)
    {
        $currency->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.currencies.list');
    }
}
