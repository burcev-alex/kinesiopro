<?php
namespace App\Orchid\Layouts\Category;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class CategorySeoRows extends Rows
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
    public function fields(): array
    {
        $translations = $this->query->get('translations');
        $rows = [];

        if (count($translations) > 0) {
            $translations->each(function ($translation) use (&$rows) {
                $rows = [
                ...$rows,
                ...[
                    Label::make('')->value('Версия ' . strtoupper($translation->locale)),
                    Input::make('translations.' . $translation->locale . '.meta_h1')->value($translation->meta_h1)->title('Мета H1'),
                    Input::make('translations.' . $translation->locale . '.meta_title')->value($translation->meta_title)->title('Мета заголовок'),
                    Input::make('translations.' . $translation->locale . '.meta_keywords')->value($translation->meta_keywords)->title('Мета ключевые слова'),
                    TextArea::make('translations.' . $translation->locale . '.meta_description')->value($translation->meta_description)->title('Мета описание'),
                ],
            ];
            });
        }
        else{
            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                $rows = [
                    ...$rows,
                    ...[
                        Label::make('')->value('Версия ' . strtoupper($locale)),
                        Input::make('translations.' . $locale . '.meta_h1')->title('Мета H1'),
                        Input::make('translations.' . $locale . '.meta_title')->title('Мета заголовок'),
                        Input::make('translations.' . $locale . '.meta_keywords')->title('Мета ключевые слова'),
                        TextArea::make('translations.' . $locale . '.meta_description')->title('Мета описание'),
                    ]
                ];
            }
        }

        return $rows;
    }
}
