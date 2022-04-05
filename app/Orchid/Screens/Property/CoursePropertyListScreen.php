<?php
namespace App\Orchid\Screens\Property;

use App\Domains\Course\Models\RefChar;
use App\Orchid\Layouts\Property\CoursePropertyListLayout;
use Orchid\Screen\Screen;

class CoursePropertyListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Характеристики курсов';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Все доступные свойства курсов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {

        return [
            'refs' => RefChar::paginate(20),
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
            CoursePropertyListLayout::class
        ];
    }
}
