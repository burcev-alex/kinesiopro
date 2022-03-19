<?php
namespace App\Orchid\Layouts\Category;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('name', 'Название'),
            TD::make('parent_name', 'Родительская')->render(function($category){
                return $category->parent_name;
            }),
            TD::make('active', 'Активность')->render(function($category){
                return $category->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('slug', 'Символьный код')->render(function($category){
                return Link::make($category->slug)->route('platform.category.edit', $category);
            })

        ];
    }
}
