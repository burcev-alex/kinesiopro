<?php
namespace App\Orchid\Screens\Course;

use App\Domains\Course\Http\Requests\OrchidCourseRequest;
use App\Domains\Course\Models\Course;
use App\Domains\Course\Services\CourseOrchidService;
use App\Orchid\Layouts\Course\CourseDescriptionRows;
use App\Orchid\Layouts\Course\CourseMainRows;
use App\Orchid\Layouts\Course\CourseMarketRows;
use App\Orchid\Layouts\Course\CoursePropsRows;
use App\Orchid\Layouts\Course\CourseSeoRows;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CourseCreateScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Создать курс';
    public $description = 'Карточка создания нового курса';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Назад')
                 ->href(route('platform.course.list'))
                 ->icon('undo'),
            
            Button::make('Сохранить')
                ->method('save')
                ->icon('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                'Курс' => [
                    CourseMainRows::class,
                    CourseMarketRows::class,
                ],
                'Характеристики' => [
                    CoursePropsRows::class
                ],
                'Детальное описание' => [
                    CourseDescriptionRows::class
                ],
                'SEO' => [
                    CourseSeoRows::class
                ]
            ])
        ];
    }

    public function save(
        Course $course,
        OrchidCourseRequest $request,
        CourseOrchidService $service
    )
    {

        $service->setModel($course);
        $validated = $request->validated();

        $service->save($validated['course']);

        if (array_key_exists('property_values', $validated)) {
            $service->saveProperties($validated['property_values']);
        }

        if (array_key_exists('markers', $validated)) {
            $service->saveMarkers($validated['markers']);
        }
       
        Alert::success('Курс успешно создан');
        return redirect()->route('platform.course.edit', $course);
    }
}
