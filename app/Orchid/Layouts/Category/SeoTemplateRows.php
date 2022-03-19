<?php
namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class SeoTemplateRows extends Rows
{

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        $translations = $this->query->get('translations');
        $rows = [];

        $helpText = "Допускается применение следующих переменных:\r\n {{product.name}} , {{product.category}} , {{product.gender}}, {{product.material}}, {{product.podkladka}}, {{product.sezon}}, {{product.sizes-box}}, {{product.price-pair}}";

        $translations->each(function ($translation) use (&$rows, $helpText) {
            $rows = [
                ...$rows,
                ...[
                    Label::make('')->value('Версия ' . strtoupper($translation->locale)),
                    Input::make('translations.' . $translation->locale . '.templates.meta_product_h1')->value($translation->meta_product_h1)->title('Шаблон мета H1')->popover($helpText),
                    Input::make('translations.' . $translation->locale . '.templates.meta_product_title')->value($translation->meta_product_title)->title('Шаблон мета название')->popover($helpText),
                    Input::make('translations.' . $translation->locale . '.templates.meta_product_keywords')->value($translation->meta_product_keywords)->title('Шаблон мета ключевые слова')->popover($helpText),
                    TextArea::make('translations.' . $translation->locale . '.templates.meta_product_description')->value($translation->meta_product_description)->title('Шаблон мета описание')->popover($helpText),
                    Quill::make('translations.' . $translation->locale . '.templates.product_description')->value($translation->product_description)->title('Шаблон описание')->help($helpText)
                ]
            ];
        });
        return $rows;
    }
}
