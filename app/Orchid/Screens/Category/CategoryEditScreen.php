<?php
namespace App\Orchid\Screens\Category;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Services\CategoryService;
use App\Orchid\Layouts\Category\CategoryMainRows;
use App\Orchid\Layouts\Category\CategorySeoRows;
use App\Orchid\Layouts\Category\CategoryShortRows;
use App\Orchid\Layouts\Category\SeoTemplateRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\Cache;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CategoryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = '';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Редактирование специализации';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $this->exists = $category->exists;

        if ($this->exists) {
            $this->description = 'Редактировать специализацию';
            if ($category) {
                $this->name = $category->name;
            }

            return [
                'category' => $category,
            ];
        } else {
            return [
                'category' => collect([]),
            ];
        }
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
            ->method('save')->icon('save'),

            Button::make('Удалить')
            ->method('remove')->icon('trash'),
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
            'Специализация' => [
                CategoryMainRows::class
            ],
            'Описание' => [
                CategoryShortRows::class
            ],
            'SEO' => [
                CategorySeoRows::class
            ]
        ])
        ];
    }

    public function save(
        Category $category,
        Request $request,
        CategoryService $service
    )
    {
        $service->setModel($category);
        $validate = $request->validate([
            'category.slug' => 'required',
            'category.*' => ''
        ]);

        $service->save($validate['category']);

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.category.edit', $category);
    }

    /**
     * Remove
     *
     * @param Category $item
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function remove(Category $category)
    {
        $category->delete()
            ? Alert::info('Вы успешно удалили запись.')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('platform.category.list');
    }
}
