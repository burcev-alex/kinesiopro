<?php


namespace App\Orchid\Screens\Course;


use App\Domains\Course\Models\Course;
use App\Orchid\Layouts\Course\CourseListLayout;
use App\Orchid\Screens\Filters\CourseFiltersLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class CourseListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Курсы';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех курсов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'courses' => Course::filters()->filtersApplySelection(CourseFiltersLayout::class)->orderBy('id', 'DESC')->paginate(10)
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
         return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CourseFiltersLayout::class,
            CourseListLayout::class
        ];
    }
}
