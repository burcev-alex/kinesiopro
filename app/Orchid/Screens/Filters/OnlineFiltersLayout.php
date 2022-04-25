<?php
namespace App\Orchid\Screens\Filters;

use App\Orchid\Filters\Online\ActiveFilter;
use App\Orchid\Filters\Online\TitleFilter;
use App\Orchid\Filters\Online\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class OnlineFiltersLayout extends Selection
{
    /**
     * Filter
     *
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            TypeFilter::class,
            TitleFilter::class,
            ActiveFilter::class,
        ];
    }
}
