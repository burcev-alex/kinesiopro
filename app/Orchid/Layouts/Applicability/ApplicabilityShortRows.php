<?php


namespace App\Orchid\Layouts\Applicability;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class ApplicabilityShortRows extends Rows
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
            return $translations->map(function($translation){
                return Quill::make('translations.' . $translation->locale . '.description')
                    ->title('Описание ' . strtoupper($translation->locale))->value($translation->description);
            })->toArray();
        }
        else{

            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                $rows = [
                    ...$rows,
                    ...[
                        Quill::make('translations.' . $locale . '.description')
                            ->title('Описание ' . strtoupper($locale)),
                    ]
                ];
            }
            return $rows;
        }

    }
}
