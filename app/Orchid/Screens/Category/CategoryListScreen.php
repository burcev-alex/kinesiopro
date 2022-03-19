<?php
namespace App\Orchid\Screens\Category;

use App\Domains\Category\Models\Category;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;

class CategoryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Категории';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Список всех категорий';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'categories' => Category::rightJoin('categories_translations', 'categories.id', '=', 'categories_translations.category_id')
            ->where('categories_translations.locale', app()->getLocale())->select('categories.*')->orderBy('categories_translations.name', 'ASC')->paginate(12)
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
            Link::make('Добавить')
                ->icon('pencil')
                ->route('platform.category.create'),
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
            CategoryListLayout::class
        ];
    }
}
