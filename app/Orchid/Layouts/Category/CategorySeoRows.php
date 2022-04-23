<?php
namespace App\Orchid\Layouts\Category;

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
        $categories = $this->query->get('categories');
        $rows = [];

        if (isset($categories)) {
            $rows = [
                ...$rows,
                ...[
                    Input::make('category.meta_h1')->value($categories->meta_h1)->title('Мета H1'),
                    Input::make('category.meta_title')->value($categories->meta_title)->title('Мета заголовок'),
                    Input::make('category.meta_keywords')->value($categories->meta_keywords)->title('Мета ключевые слова'),
                    TextArea::make('category.meta_description')->value($categories->meta_description)->title('Мета описание'),
                ],
            ];
        } else {
            $rows = [
                ...$rows,
                ...[
                    Input::make('category.meta_h1')->title('Мета H1'),
                    Input::make('category.meta_title')->title('Мета заголовок'),
                    Input::make('category.meta_keywords')->title('Мета ключевые слова'),
                    TextArea::make('category.meta_description')->title('Мета описание'),
                ],
            ];
        }

        return $rows;
    }
}
