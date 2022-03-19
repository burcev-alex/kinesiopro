<?php
namespace App\Orchid\Layouts\Property;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductPropertyListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'refs';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('slug'),
            TD::make('name')->render(function($ref){
                return Link::make($ref->name)->route('platform.property.edit', $ref);
            }),
        ];
    }
}
