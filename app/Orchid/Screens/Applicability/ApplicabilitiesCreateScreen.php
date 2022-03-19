<?php


namespace App\Orchid\Screens\Applicability;


use App\Domains\Applicability\Models\Applicability;
use App\Domains\Product\Services\ApplicabilitysService;
use App\Orchid\Layouts\Applicability\ApplicabilityMainRows;
use App\Orchid\Layouts\Applicability\ApplicabilitySeoRows;
use App\Orchid\Layouts\Applicability\ApplicabilityShortRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ApplicabilitiesCreateScreen extends Screen
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
    public $description = 'Создание применимости';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Applicability $applicability): array
    {
        $this->exists = $applicability->exists;

        return [
            'applicability' => collect([]),
            'translations' => collect([]),
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
                'Применимость' => [
                    ApplicabilityMainRows::class
                ],
                'Описание' => [
                    ApplicabilityShortRows::class
                ],
                'SEO' => [
                    ApplicabilitySeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Applicability $applicability,
        Request $request,
        ApplicabilitysService $service
    )
    {
        $service->setModel($applicability);
        $validate = $request->validate([
            'applicability.slug' => 'required',
            'translations.*.name' =>'required',

            'applicability.*' => '',
            'translations.*.*' =>'',
            'translations.*.*.*' =>'',
        ]);
        // Log::info($validate);

        $service->save($validate['applicability']);
        $service->saveTranslations($validate['translations']);

        //Cache::tags(['applicabilitys', 'menuApplicabilitys.ru', 'menuApplicabilitys.uk'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.applicabilities.edit', $applicability);

    }
}
