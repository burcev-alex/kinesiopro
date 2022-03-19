<?php


namespace App\Orchid\Layouts\Applicability;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ApplicabilityMainRows extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $translations = $this->query->get('translations');

        $rows = [];

        if (count($translations) > 0) {
            $rows = [
                ...$translations->map(function($translation){
                    return Input::make('translations.' . $translation->locale . '.name')
                        ->title('Название ' . strtoupper($translation->locale))
                        ->required()
                        ->value($translation->name);
                })->toArray()
            ];
        }else{
            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                $rows = [
                    ...$rows,
                    ...[
                        Input::make('translations.' . $locale . '.name')->title('Название ' . strtoupper($locale))->required(),
                    ]
                ];
            }
        }

        $rows = [
            ...$rows,
            ...[
                Input::make('applicability.slug')->title('Символьный код')->required(),
                CheckBox::make('applicability.active')->title('Активность')
            ]
        ];

        return $rows;
    }
}
