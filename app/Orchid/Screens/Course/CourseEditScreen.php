<?php
namespace App\Orchid\Screens\Course;

use App\Domains\Blog\Models\Component;
use App\Domains\Course\Http\Requests\OrchidCourseRequest;
use App\Domains\Course\Models\Course;
use App\Domains\Course\Models\CourseBlock as AppCourseBlock;
use App\Domains\Course\Models\CourseDesciptionComponent as AppCourseDesciptionComponent;
use App\Orchid\Layouts\Course\CourseBlock;
use App\Orchid\Layouts\Course\CourseDesciptionComponent;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Services\CourseOrchidService;
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
use Orchid\Screen\Actions\DropDown;
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
    public $components;

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
        $this->components = $course->components;

        $this->name = $course != null ? $course->name : "";
        
        return [
            'course' => $course,
            'category_main' => $course->category_id ? $course->category_id : null,
            'properties' => $course->properties,
            'blocks' => $course->blocks,
            'components' => $course->components,
            'property_values' => $course->property_values,
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

            DropDown::make('Блоки курса')
                ->slug('sub-menu-block')
                ->icon('code')
                ->list([
                    Button::make('Добавить блок')
                        ->method('addblock')
                        ->icon('plus-alt'),

                    ModalToggle::make('Удалить блок')
                    ->method('deleteblock')
                    ->modal('deleteblock')->icon('trash')
                    ->canSee($this->blocks->count() > 0),
            ]),
            
            DropDown::make('Детальное описание')
            ->slug('sub-menu-descriptionn')
            ->icon('code')
            ->list([
                ModalToggle::make('Добавить описание')
                    ->modal('addcomponent')
                    ->method('addcomponent')
                    ->icon('plus-alt'),
                ModalToggle::make('Удалить описание')
                ->method('deletecomponent')
                ->modal('deletecomponent')->icon('trash')
                ->canSee($this->components->count() > 0),
            ]),
            Button::make('Удалить')
                ->method('remove')
                ->icon('close'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $optionsBlock = [];
        $blocks = $this->blocks->map(function ($item) use (&$optionsBlock) {
            $optionsBlock[$item->id] = "Блок " . $item->sort . " - " . $item->title;
            $block = new CourseBlock($item);
            return $block->accordionField();
        })->toArray();

        $optionsComponent = [];
        $components = $this->components->map(function ($item) use (&$optionsComponent) {
            $optionsComponent[$item->id] = "Компонент " . $item->sort . " - " . $item->component->name;
            $component = new CourseDesciptionComponent($item);
            return $component->accordionField();
        })->toArray();

        return [
            Layout::modal('addcomponent', [
                Layout::rows([
                    Select::make('component')->fromModel(Component::class, 'name')->value([]),
                    Input::make('item.id')->value($this->data->id)->hidden(),
                ])

            ])->title('Выберите компонент'),
            Layout::modal('deletecomponent', [
                Layout::rows([
                    Select::make('component')->options($optionsComponent)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('deleteblock', [
                Layout::rows([
                    Select::make('block')->options($optionsBlock)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('remove', [])->title('Подтвердите удаление'),
            Layout::tabs([
                'Курс' => [
                    CourseMainRows::class,
                    CourseMarketRows::class,
                ],
                'Характеристики' => [
                    CoursePropsRows::class
                ],
                'Блоки курса' => $blocks,
                "Детальное описание" => $components,
                'SEO' => [
                    CourseSeoRows::class
                ]
            ]),
        ];
    }

    public function addblock(Course $course)
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

    public function addcomponent(Request $request)
    {
        $component = Component::find($request->component);
        $fields = [];
        $item = $request->item['id'];

        foreach ($component->fields as $key => $value) {
            $fields[$value] = '';
        }

        AppCourseDesciptionComponent::create([
            "course_id" => $item,
            "component_id" => $component->id,
            "sort" => 0,
            "fields" => $fields
        ]);

        Toast::success('Вы успешно создали новый компонент описания - ' . $component->name);
        return redirect()->back();
    }


    public function deletecomponent(Request $request)
    {
        $component = AppCourseDesciptionComponent::find($request->component);
        $component->delete();
        return redirect()->back();
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

        if (array_key_exists('blocks', $validated)) {
            $service->saveBlocks($validated['blocks']);
        }

        if (array_key_exists('components', $validated)) {
            $service->saveComponents($validated['components']);
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
    )
    {

        $service->setModel($course);
        $validated = $request->validated();

        // удаляем свойства
        $properties = CourseProperty::where('course_id', $course->id)->get();
        $propIds = [];
        foreach ($properties as $variant) {
            $propIds[] = $variant->id;
        }
        $course->properties()->delete();

        // удаляем блоки
        $blocks = AppCourseBlock::where('course_id', $course->id)->get();
        $propIds = [];
        foreach ($blocks as $variant) {
            $propIds[] = $variant->id;
        }
        $course->blocks()->delete();
        
        $service->deleteById($course->id);

        Alert::success('Курс успешно удален');
        return redirect()->route('platform.course.list');
    }
}
