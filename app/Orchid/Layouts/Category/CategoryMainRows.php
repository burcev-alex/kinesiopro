<?php
namespace App\Orchid\Layouts\Category;

use App\Domains\Category\Models\Category;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class CategoryMainRows extends Rows
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

        // категории
        $arCategoryList = [
            '' => '- пусто -'
        ];

        // если это родительский раздел, то выводить их всех дочерних
        $firstCategory = Category::where('parent_id', null)->with('translation')->get();
        foreach ($firstCategory as $category) {
            $arCategoryList[$category->id] = $category->translation ? $category->translation->name : "-";

            $childCategory = Category::where('parent_id', $category->id)->with('translation')->get();

            if (IntVal($childCategory->count()) > 0) {
                foreach ($childCategory as $children) {
                    $arCategoryList[$children->id] = ". . ".$children->translation->name;

                    $childSubCategory = Category::where('parent_id', $children->id)->with('translation')->get();

                    if (IntVal($childSubCategory->count()) > 0) {
                        foreach ($childSubCategory as $subChildren) {
                            $arCategoryList[$subChildren->id] = ". . . ".$subChildren->translation->name;
                        }
                    }
                }
            }
        }

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
        }
        else{
            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                $rows = [
                    ...$rows,
                    ...[
                        Input::make('translations.' . $locale . '.name')
                        ->title('Название ' . strtoupper($locale))
                        ->required(),
                    ]
                ];
            }
        }

        $rows = [
            ...$rows,
            ...[
                Input::make('category.slug')->title('Символьный код')->required(),
                CheckBox::make('category.active')->title('Активность'),
                Select::make('category.parent_id')->options($arCategoryList)->title('Родительская категория'),
            ]
        ];

        return $rows;
    }
}
