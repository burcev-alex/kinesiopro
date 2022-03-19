<?php
namespace App\Orchid\Layouts\Property;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class ProductPropertyMainRows extends Rows
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
        $ref = $this->query->get('ref');
        return [
            Input::make('ref.external_id')->value($ref->external_id)->title("GUID")->required(),
            ...$translations->map(function($translation){
                return Input::make('translations.' . $translation->locale . '.name')
                ->value($translation->name)
                ->title("Название " . strtoupper($translation->locale));
            })->toArray(),
            Input::make('ref.slug')->value($ref->slug)->title("Символьный код")->required(),
            Input::make('ref.sort')->value($ref->sort)->title("Сортировка")->required(),
            CheckBox::make('ref.active')->value($ref->active)->title('Активность')
        ];
    }
}
