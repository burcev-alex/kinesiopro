<?php
namespace App\Orchid\Screens\Online;

use App\Domains\Blog\Models\Component;
use App\Domains\Online\Http\Requests\OrchidOnlineRequest;
use App\Domains\Online\Models\Online;
use App\Domains\Online\Models\OnlineBlock as AppOnlineBlock;
use App\Domains\Online\Models\OnlineDesciptionComponent as AppOnlineDesciptionComponent;
use App\Orchid\Layouts\Online\OnlineDesciptionComponent;
use App\Domains\Online\Services\OnlineOrchidService;
use App\Orchid\Layouts\Online\OnlineMainRows;
use App\Orchid\Layouts\Online\OnlinePreviewRows;
use App\Orchid\Layouts\Online\OnlineSeoRows;
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

class OnlineEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'OnlineEditScreen';
    public $service;
    
    public $components;

    /**
     * Display header description.
     *
     * @var string|null
     */
    protected $data;

    public $description = 'Карточка редактирования онлайн-курса';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Online $online): array
    {
        $this->data = $online;
        $this->components = $online->components;

        $this->name = $online != null ? $online->title : "";
        
        return [
            'online' => $online,
            'components' => $online->components,
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        $modalDeleteDescr = ModalToggle::make('Удалить описание')
        ->method('deletecomponent')
        ->modal('deletecomponent')->icon('trash')
        ->canSee($this->components->count() > 0);

        return [
            Link::make('Назад')
                 ->href(route('platform.online.list'))
                 ->icon('undo'),
                 
             Link::make('Просмотр')
                 ->href(route('online.single', ['slug' => $this->data->slug]))
                 ->target('_blank')
                 ->icon('browser'),
            
            Button::make('Сохранить')
                ->method('save')
                ->icon('save'),
            
            DropDown::make('Детальное описание')
            ->slug('sub-menu-descriptionn')
            ->icon('code')
            ->list([
                ModalToggle::make('Добавить описание')
                    ->modal('addcomponent')
                    ->method('addcomponent')
                    ->icon('plus-alt'),
                $modalDeleteDescr,
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
        $optionsComponent = [];
        $components = $this->components->map(function ($item) use (&$optionsComponent) {
            $optionsComponent[$item->id] = "Компонент " . $item->sort . " - " . $item->component->name;
            $component = new OnlineDesciptionComponent($item);
            return $component->accordionField();
        })->toArray();

        return [
            Layout::modal('addcomponent', [
                Layout::rows([
                    Select::make('component')->fromModel(Component::class, 'name')->value([]),
                    Input::make('item.id')->hidden(),
                ])

            ])->title('Выберите компонент'),
            Layout::modal('deletecomponent', [
                Layout::rows([
                    Select::make('component')->options($optionsComponent)
                ])
            ])->title('Подтвердите удаление'),
            Layout::modal('remove', [])->title('Подтвердите удаление'),
            Layout::tabs([
                'Курс' => [
                    OnlineMainRows::class
                ],
                'Анонс' => [
                    OnlinePreviewRows::class
                ],
                "Детальное описание" => $components,
                'SEO' => [
                    OnlineSeoRows::class
                ]
            ]),
        ];
    }

    public function addcomponent(Request $request)
    {
        $component = Component::find($request->component);
        $fields = [];
        $item = $request->item['id'];

        foreach ($component->fields as $key => $value) {
            $fields[$value] = '';
        }

        AppOnlineDesciptionComponent::create([
            "online_id" => $item,
            "component_id" => $component->id,
            "sort" => 0,
            "fields" => $fields
        ]);

        Toast::success('Вы успешно создали новый компонент описания - ' . $component->name);
        return redirect()->back();
    }


    public function deletecomponent(Request $request)
    {
        $component = AppOnlineDesciptionComponent::find($request->component);
        $component->delete();
        return redirect()->back();
    }

    public function save(
        Online $online,
        OrchidOnlineRequest $request,
        OnlineOrchidService $service
    )
    {

        $service->setModel($online);
        $validated = $request->validated();

        $service->save($validated['online']);

        if (array_key_exists('images', $validated)) {
            $service->saveImages($validated['images']);
        }

        if (array_key_exists('components', $validated)) {
            $service->saveComponents($validated['components']);
        }
       
        Alert::success('Курс успешно изменен');
        return redirect()->route('platform.online.edit', $online);
    }

    public function remove(
        Online $online,
        OrchidOnlineRequest $request,
        OnlineOrchidService $service
    )
    {

        $service->setModel($online);
        $validated = $request->validated();

        // удаляем компоненты
        $online->components()->delete();
        
        $service->deleteById($online->id);

        Alert::success('Курс успешно удален');
        return redirect()->route('platform.online.list');
    }
}
