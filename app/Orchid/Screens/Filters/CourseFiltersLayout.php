<?php
namespace App\Orchid\Screens\Filters;

use App\Orchid\Filters\Course\ActiveFilter;
use App\Orchid\Filters\Course\TitleFilter;
use App\Orchid\Filters\Course\MarkerFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CourseFiltersLayout extends Selection
{
    /**
     * Filters
     *
     * @return Filter[]
     */
    public function filters(): array
    {
        return [
            TitleFilter::class,
            MarkerFilter::class,
            ActiveFilter::class,
        ];
    }
}
