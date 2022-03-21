<?php
namespace App\Domains\Category\Observers;

use App\Domains\Category\Models\Category;

/**
 * Class CategoryObserver
 * @package App\Observers
 */
class CategoryObserver
{
    /**
     * @param Category $category
     */
    public function deleting(Category $category)
    {
    }

    /**
     * Listen to the Category created event.
     *
     * @param Category $category
     * @return void
     * @throws
     */
    public function created(Category $category)
    {
        clearCacheByArray($this->getCacheKeys($category));
        clearCacheByTags($this->getCacheTags($category));
    }

    /**
     * Listen to the Category updating event.
     *
     * @param Category $category
     * @return void
     * @throws
     */
    public function updated(Category $category)
    {
        clearCacheByArray($this->getCacheKeys($category));
        clearCacheByTags($this->getCacheTags($category));
    }


    /**
     * Listen to the Category deleting event.
     *
     * @param Category $category
     * @return void
     * @throws
     */
    public function deleted(Category $category)
    {
        clearCacheByArray($this->getCacheKeys($category));
        clearCacheByTags($this->getCacheTags($category));
    }

    /**
     * @param Category $category
     * @return array
     */
    private function getCacheKeys(Category $category): array
    {
        return [

        ];
    }

    /**
     * @param Category $category
     * @return array
     */
    private function getCacheTags(Category $category): array
    {
        return [
            'categories'
        ];
    }
}
