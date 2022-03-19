<?php
namespace App\Orchid\Screens\Category;

use App\Domains\Category\Models\Category;
use App\Domains\Product\Services\CategoryService;
use App\Orchid\Layouts\Category\CategoryMainRows;
use App\Orchid\Layouts\Category\CategorySeoRows;
use App\Orchid\Layouts\Category\CategoryShortRows;
use App\Orchid\Layouts\Category\SeoTemplateRows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
    public $description = 'Создание категории';

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
            'translations' => collect([]),
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
                'Категория' => [
                    CategoryMainRows::class
                ],
                'Описание' => [
                    CategoryShortRows::class
                ],
                'SEO' => [
                    CategorySeoRows::class
                ],
                'Шаблоны' => [
                    SeoTemplateRows::class
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
            'translations.*.name' =>'required',

            'category.*' => '',
            'translations.*.*' =>'',
            'translations.*.*.*' =>'',
        ]);
        // Log::info($validate);

        $service->save($validate['category']);
        $service->saveTranslations($validate['translations']);
        $service->saveTemplates($validate['translations']);

       // Cache::tags(['categories', 'menuCategories.ru'])->flush();

        Alert::success('Изменения успешно сохранены');
        return redirect()->route('platform.category.edit', $category);

    }
}
