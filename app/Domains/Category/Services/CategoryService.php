<?php
namespace App\Domains\Category\Services;

use App\Domains\Category\Models\Category;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class CategoryService extends BaseService
{
    /**
     * Группировка по родительскому признаку
     *
     * @var array
     */
    protected array $groupedIdsBySlug;

    /**
     * Разделы учатсвующие в фильтрации
     *
     * @var array
     */
    protected array $categoriesFilterIds;

    /**
     * __construct
     *
     * @param  Category $product
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function save(array $fields): self
    {
        if (array_key_exists('attachment_id', $fields)) {
            $fields['attachment_id'] = current($fields['attachment_id']);
        }

        $this->model->fill($fields);

        if (isset($fields['active'])) {
            $this->model->active = true;
        } else {
            $this->model->active = false;
        }

        $this->model->save();

        return $this;
    }

    /**
     * Get By Slug
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Category::query()
            ->where('slug', $slug)
            ->first();
    }

    public function getHomeCategoriesOneLevel()
    {
        return Category::where('active', 1)->orderBy('sort', 'asc')->get();
    }

    /**
     * Get menu categories list
     *
     * @return mixed
     */
    public function getCachedMenuCategoriesList()
    {
        return Cache::tags('categories')->rememberForever('menuCategories.' . app()->getLocale(), function () {
            $categories = $this->model->newQuery()
                ->where('active', 1)
                ->select(['id', 'slug', 'name'])
                ->get();
            return $this->generateCategoriesFormat($categories);
        });
    }

    /**
     * Генерация схемы разделов для корректного вывода в публичной части
     *
     * @param array $categories
     * @return array
     */
    public function generateCategoriesFormat($categories)
    {
        $return = [];
        foreach ($categories as $category) {
            $return[] = [
                'id' => $category->id,
                'slug' => $category->slug,
                'name' => $category->name ?? '',
            ];
        }
 
        return $return;
    }

    /**
     * Группировка разделов
     *
     * @return array
     * @throws \Exception
     */
    public function getGroupedCategories()
    {
        if (!isset($this->groupedIdsBySlug)) {
            $categories = $this->getCachedMenuCategoriesList();
            $return = [];
            foreach ($categories as $category) {
                $return[$category['slug']] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'ids' => [$category['id']]
                ];
            }
            $this->groupedIdsBySlug = $return;
        }
        return $this->groupedIdsBySlug;
    }

    /**
     * Разделы группы
     *
     * @return array
     */
    public function getGroupedCategoriesIds(): array
    {
        if (!isset($this->categoriesFilterIds)) {
            $categories = $this->getCachedMenuCategoriesList();
            foreach ($categories as $category) {
                $this->categoriesFilterIds[$category['id']] = [$category['id']];
            }
        }
        return $this->categoriesFilterIds;
    }
}
