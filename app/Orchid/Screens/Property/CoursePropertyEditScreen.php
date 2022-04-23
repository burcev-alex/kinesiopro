<?php
namespace App\Orchid\Screens\Property;

use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Services\RefCharService;
use App\Orchid\Layouts\Property\CoursePropertyMainRows;
use App\Orchid\Layouts\Property\CoursePropertyValuesRows;
use Illuminate\Http\Request;
use Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CoursePropertyEditScreen extends Screen
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
            'values' => $ref->values,
            'slug' => $ref->slug
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
                    CoursePropertyMainRows::class
                ],
                "Значения" => [
                    CoursePropertyValuesRows::class
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
            'ref.active' => '',
            'char_values.*' => '',
        ]);
        
        $service->save($valide['ref']);
        $service->saveValues($valide['char_values']);

        Alert::success('Характеристика успешно изменена');
        return redirect()->route('platform.property.edit', $ref);
    }
}
