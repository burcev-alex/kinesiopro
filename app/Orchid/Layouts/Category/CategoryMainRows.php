<?php
namespace App\Orchid\Layouts\Category;

use App\Domains\Category\Models\Category;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
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
        $categories = $this->query->get('categories');
        
        $rows = [];

        $rows = [
            ...$rows,
            ...[
                Input::make('category.name')->title('Название')->required(),
                Input::make('category.slug')->title('Символьный код')->required(),
                Input::make('category.sort')->title('Сортировка'),
                CheckBox::make('category.active')->title('Активность'),
                Upload::make('category.attachment_id')
                ->value($categories ? ($categories->attachment ? [$categories->attachment->id] : []) : [])
                ->title('Иконка'),
            ]
        ];

        return $rows;
    }
}
