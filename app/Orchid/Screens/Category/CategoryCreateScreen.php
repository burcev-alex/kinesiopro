<?php
namespace App\Orchid\Screens\Category;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Services\CategoryService;
use App\Orchid\Layouts\Category\CategoryMainRows;
use App\Orchid\Layouts\Category\CategorySeoRows;
use App\Orchid\Layouts\Category\CategoryShortRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CategoryCreateScreen extends Screen
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
    public $description = 'Создание специализации';

    public $exists = false;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Category $category): array
    {
        $this->exists = $category->exists;

        return [
            'category' => collect([]),
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
            Button::make('Сохранить')
            ->method('save')->icon('save')
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

        Cache::tags(['categories'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.category.edit', $category);
    }
}
