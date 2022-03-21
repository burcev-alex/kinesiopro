<?php
namespace App\Orchid\Layouts\Category;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

class CategoryShortRows extends Rows
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

        if ($categories) {
            return [
                Quill::make('category.description')
                ->title('Описание')->value($categories->description)
            ];
        }
        else{
            $rows = [
                ...$rows,
                ...[
                    Quill::make('category.description')
                    ->title('Описание'),
                ]
            ];

            return $rows;
        }
        
    }
}
