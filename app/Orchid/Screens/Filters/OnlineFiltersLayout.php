<?php
namespace App\Orchid\Screens\Filters;

use App\Orchid\Filters\Online\ActiveFilter;
use App\Orchid\Filters\Online\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class OnlineFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            TitleFilter::class,
            ActiveFilter::class
        ];
    }
}
