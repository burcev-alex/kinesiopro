<?php


namespace App\Orchid\Screens\Applicability;

use App\Domains\Product\Services\ApplicabilitysService;
use App\Domains\Applicability\Models\Applicability;
use App\Orchid\Layouts\Applicability\ApplicabilityMainRows;
use App\Orchid\Layouts\Applicability\ApplicabilitySeoRows;
use App\Orchid\Layouts\Applicability\ApplicabilityShortRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ApplicabilitiesEditScreen extends Screen
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
    public $description = 'Редактирование категории';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Applicability $applicability){
        $this->exists = $applicability->exists;
        if ($this->exists) {
            $this->description = 'Редактировать категорию';
            if ($applicability) {
                $this->name = $applicability->name;
            }

            return [
                'applicability' => $applicability,
                'translations' => $applicability ? $applicability->translations : [],
            ];
        }
        else{
            return [
                'applicability' => collect([]),
                'translations' => collect([]),
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
                'Категория' => [
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
    ){
        $service->setModel($applicability);
        $validate = $request->validate([
            'applicability.slug' => 'required',
            'translations.*.name' =>'required',

            'applicability.*' => '',
            'translations.*.*' =>'',
            'translations.*.*.*' =>'',
        ]);
        $service->save($validate['applicability']);
        $service->saveTranslations($validate['translations']);

        //Cache::tags(['applicabilitys', 'menuApplicabilitys.ru', 'menuApplicabilitys.uk'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.applicabilities.edit', $applicability);
    }

    /**
     * @param Applicability $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Applicability $applicability)
    {
        $applicability->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        //Cache::tags(['applicabilitys', 'menuApplicabilitys.ru', 'menuApplicabilitys.uk'])->flush();

        return redirect()->route('platform.applicabilities.list');
    }
}
