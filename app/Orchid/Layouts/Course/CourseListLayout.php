<?php
namespace App\Orchid\Layouts\Course;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CourseListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'courses';

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
            
            TD::make('active', 'Активность')->render(function ($product) {
                return $product->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('code', 'Символьный код')->render(function ($product) {
                return Link::make($product->slug)->route('platform.course.edit', $product);
            }),

        ];
    }
}
