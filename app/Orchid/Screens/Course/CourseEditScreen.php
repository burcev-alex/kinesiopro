<?php
namespace App\Orchid\Screens\Course;

use App\Domains\Course\Http\Requests\OrchidCourseRequest;
use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseBlock as AppCourseBlock;
use App\Orchid\Layouts\Course\CourseBlock;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Services\CourseOrchidService;
use App\Orchid\Layouts\Course\CourseDescriptionRows;
use App\Orchid\Layouts\Course\CourseMainRows;
use App\Orchid\Layouts\Course\CourseMarketRows;
use App\Orchid\Layouts\Course\CoursePropsRows;
use App\Orchid\Layouts\Course\CourseSeoRows;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class CourseEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CourseEditScreen';
    public $service;
    
    public $blocks;

    /**
     * Display header description.
     *
     * @var string|null
     */
    protected $data;

    public $description = 'Карточка редактирования курса';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Course $course): array
    {
        $this->data = $course;
        $this->blocks = $course->blocks;

        $this->name = $course != null ? $course->name : "";
        
        return [
            'course' => $course,
            'category_main' => $course->category_id ? $course->category_id : null,
            'properties' => $course->properties,
            'blocks' => $course->blocks,
            'property_values' => $course->property_values
        ];
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
                 
             Link::make('Просмотр')
                 ->href(route('courses.card', ['slug' => $this->data->slug]))
                 ->target('_blank')
                 ->icon('browser'),
            
            Button::make('Сохранить')
                ->method('save')
                ->icon('save'),

            Button::make('Добавить блок')
                ->method('addblock')
                ->icon('plus-alt'),

            ModalToggle::make('Удалить блок')->method('deleteblock')->modal('deleteblock')->icon('trash')->canSee($this->blocks->count() > 0),

            Button::make('Удалить')
                ->method('remove')
                ->icon('close')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $options = [];
        $blocks = $this->blocks->map(function ($item) use (&$options) {
            $options[$item->id] = "Блок " . $item->sort . " - " . $item->title;
            $block = new CourseBlock($item);
            return $block->accordionField();
        })->toArray();

        return [
            Layout::modal('deleteblock', [
                Layout::rows([
                    Select::make('block')->options($options)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('remove', [])->title('Подтвердите удаление'),
            Layout::tabs([
                'Курс' => [
                    CourseMainRows::class,
                    CourseMarketRows::class
                ],
                'Характеристики' => [
                    CoursePropsRows::class
                ],
                'Блоки курса' => $blocks,
                'Детальное описание' => [
                    CourseDescriptionRows::class
                ],
                'SEO' => [
                    CourseSeoRows::class
                ]
            ])
        ];
    }

    public function addblock(Course $course, Request $request)
    {
        $item = $course->id;

        AppCourseBlock::create([
            "course_id" => $item,
            "sort" => 0,
            "teacher_id" => 1,
            "title" => 'Example'
        ]);

        Toast::success('Вы успешно создали новый блок');
        return redirect()->back();
    }

    public function deleteblock(Request $request)
    {
        $block = AppCourseBlock::find($request->block);
        $block->delete();
        return redirect()->back();
    }

    public function save(
        Course $course,
        OrchidCourseRequest $request,
        CourseOrchidService $service
    ) {

        $service->setModel($course);
        $validated = $request->validated();

        $service->save($validated['course']);

        if (array_key_exists('property_values', $validated)) {
            $service->saveProperties($validated['property_values']);
        }

        if (array_key_exists('blocks', $validated)) {
            $service->saveBlocks($validated['blocks']);
        }

        if (array_key_exists('teachers', $validated)) {
            $service->saveTeachers($validated['teachers']);
        }

        if (array_key_exists('markers', $validated)) {
            $service->saveMarkers($validated['markers']);
        }
       
        Alert::success('Курс успешно изменен');
        return redirect()->route('platform.course.edit', $course);
    }

    public function remove(
        Course $course,
        OrchidCourseRequest $request,
        CourseOrchidService $service
    ) {

        $service->setModel($course);
        $validated = $request->validated();

        // удаляем свойства
        $properties = CourseProperty::where('course_id', $course->id)->get();
        $propIds = [];
        foreach($properties as $variant){
            $propIds[] = $variant->id;
        }
        $course->properties()->delete();

        // удаляем блоки
        $blocks = AppCourseBlock::where('course_id', $course->id)->get();
        $propIds = [];
        foreach($blocks as $variant){
            $propIds[] = $variant->id;
        }
        $course->blocks()->delete();
        
        $service->deleteById($course->id);

        Alert::success('Курс успешно удален');
        return redirect()->route('platform.course.list');
    }
}
