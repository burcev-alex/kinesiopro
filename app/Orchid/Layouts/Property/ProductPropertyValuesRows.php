<?php
namespace App\Orchid\Layouts\Property;

use Log;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Layouts\Rows;

class ProductPropertyValuesRows extends Rows
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
        // получили список всех ref_char_values
        $values = $this->query->get('values');
        // разделяем каждый slug на локали
        $rows = $values->mapToGroups(function($item){
            return [$item['slug'] => $item];
        })->map(function($item, $slug) {
            // для каждого слага выводим обозначения
            return [
                // можно динамически указывать локали, но вроде бы их пока больше 
                // не предвидится, так что ручками..
                'ru' => $item->where('locale' , 'ru')->first() ? $item->where('locale' , 'ru')->first()->value : "",
                'uk' => $item->where('locale' , 'uk')->first() ? $item->where('locale' , 'uk')->first()->value : "",
                'slug' => $slug,
                'external_id' => $item->where('locale' , 'ru')->first()->external_id
            ];            
        })->toArray();
        

        return [
            Matrix::make('char_values')
            ->columns([
                'Название RU' => 'ru',
                'Название UK' => 'uk',
                'Символьный код' => 'slug',
                'GUID' => 'external_id'
            ])->value($rows)->maxRows(count($rows))
        ];
    }
}
