<?php


namespace App\Orchid\Screens\Applicability;


use App\Domains\Applicability\Models\Applicability;
use App\Orchid\Layouts\Applicability\ApplicabilityListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class ApplicabilitiesListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Применимость';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех применимость';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'applicabilites' => Applicability::rightJoin('applicabilities_translations', 'applicabilities.id', '=', 'applicabilities_translations.applicability_id')
                ->where('applicabilities_translations.locale', app()->getLocale())->select('applicabilities.*')->orderBy('applicabilities_translations.name', 'ASC')->paginate(12)
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
                ->route('platform.applicabilities.create'),
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
            ApplicabilityListLayout::class
        ];
    }
}
