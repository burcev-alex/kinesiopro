<?php
namespace App\Orchid\Layouts\Applicability;

use Log;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ApplicabilityListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'applicabilites';

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

            TD::make('active', 'Активность')->render(function($applicability){
                return $applicability->active ? 'да' : '<b>нет</b>';
            }),
            TD::make('slug', 'Символьный код')->render(function($applicability){
                return Link::make($applicability->slug)->route('platform.applicabilities.edit', $applicability);
            })
        ];
    }
}
