<?php
namespace App\Orchid\Screens\Property;

use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Services\RefCharService;
use App\Orchid\Layouts\Property\ProductPropertyMainRows;
use App\Orchid\Layouts\Property\ProductPropertyValuesRows;
use Illuminate\Http\Request;
use Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductPropertyEditScreen extends Screen
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
    public $description = 'Редактирование характеристики';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(RefChar $ref): array
    {
        $this->name = $ref->name;
        return [
            'ref' => $ref,
            'translations' => $ref->translations,
            'values' => $ref->values
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
                "Характеристика" => [
                    ProductPropertyMainRows::class
                ],
                "Значения" => [
                    ProductPropertyValuesRows::class
                ]
            ])
        ];
    }
    
    public function save(
        RefChar $ref,
        Request $request,
        RefCharService $service
    )
    {
        $service->setModel($ref);
        $valide = $request->validate([
            'ref.slug' => 'required',
            'ref.external_id' => 'required',
            'ref.active' => '',
            'translations.*' => '',
            'char_values.*' => '',
        ]);
        // Log::info($valide);
        $service->save($valide['ref']);
        $service->saveTranslations($valide['translations']);
        $service->saveValues($valide['char_values']);

        Alert::success('Характеристика успешно изменена');
        return redirect()->route('platform.property.edit', $ref);
    }
}
