<?php
namespace App\Domains\Product\Services;

use App\Domains\Category\Models\CategoriesTranslation;
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
     * @var array
     */
    protected array $groupedIdsBySlug;

    /**
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
        $this->model->fill($fields);

        if (isset($fields['active'])) $this->model->active = true;
        else $this->model->active = false;

        $this->model->save();

        return $this;
    }
    public function saveTranslations(array $translations): self
    {

        foreach ($translations as $locale => $fields) {
            $entity = $this->model->translations->where('locale', $locale)
            ->first();

            if ($entity) {
                $entity->fill($fields)->save();
            }
            else{
                $fields['category_id'] = $this->model->id;
                $fields['locale'] = $locale;
                CategoriesTranslation::create($fields);
            }
        }

        return $this;
    }

    public function saveTemplates(array $translations): self
    {
        foreach ($translations as $locale => $translation) {
            $entity = $this->model->translations->where('locale', $locale)->first();
            if ($entity) {
                $entity->fill($translation['templates'])->save();
            }
        }

        // Раскомментировать, если нужно переписать всем товарам сео из шаблона категории

        // $this->model->products->each(function ($product) use ($translations) {

        //     foreach ($translations as $locale => $translation) {
        //         $product_translation = $product->translations->where('locale', $locale)->first();
        //         $translation = $translation['templates'];
        //         $productData = [
        //             "product" => [
        //                 "name" => $product_translation->name
        //             ]
        //         ];

        //         $product_translation->fill([
        //             "meta_title" => seo_parse(
        //                 $translation['meta_product_title'] != null ? $translation['meta_product_title'] : $product_translation->meta_title,
        //                 $productData
        //             ),
        //             "meta_keywords" => seo_parse(
        //                 $translation['meta_product_keywords'] != null ? $translation['meta_product_keywords'] : $product_translation->meta_keywords,
        //                 $productData
        //             ),
        //             "meta_description" => seo_parse(
        //                 $translation['meta_product_description'] != null ? $translation['meta_product_description'] : $product_translation->meta_description,
        //                 $productData
        //             ),
        //             "meta_h1" => seo_parse(
        //                 $translation['meta_product_h1'] != null ? $translation['meta_product_h1'] : $product_translation->meta_h1,
        //                 $productData
        //             ),
        //         ])->save();
        //     }
        // });
        return $this;
    }

    public function saveImages(array $images){
        if(!isset($images['attachment_id'])) $images['attachment_id'] = [];        
        foreach($images as $key => $items){
            foreach($items as $item){
                if($item){
                    $this->attachmentId($item);
                }
                Category::Where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }

    private function attachmentId(int $attachment_id){
        $attach = Attachment::find($attachment_id);

            // проверка на соответствие имени стандартам #68165 
            // https://b24.ac-step.com/workgroups/group/86/tasks/task/view/68165/
            
            // (берется слаг товара и используется в качестве имени)
            if(!Str::contains($attach->name, $this->model->name)){
                
                $current_path = $attach->physicalPath();
                do {
                    $name = $this->model->name . '-' . random_int(0, 100);
                    $find = Attachment::where('name' , $name)->first();
                } while ($find);
                $attach->fill(['name' => $name, 'original_name' => $name])->save();
                
                // на боевом можно использовать вариацию с move, а не copy,
                // но сейчас нужен copy, т.к. при посеве изображений иногда изображения дублируются 
                // Storage::disk('public')->move($current_path, $attach->physicalPath());
                if(!Storage::disk('public')->exists($attach->physicalPath()))
                    Storage::disk('public')->copy($current_path, $attach->physicalPath());
                
            }
        return;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Category::query()
            ->where('slug', $slug)
            ->first();
    }

    public function getHomeCategoriesOneLevel(){
       return Category::Where('active', 1)->Where('parent_id', null)->orderBy('sort', 'asc')->get();       
    }

    /**
     * Get menu categories list
     * @return mixed
     */
    public function getCachedMenuCategoriesList()
    {
        return Cache::tags('categories')->rememberForever('menuCategories.' . app()->getLocale(), function () {
            $categories = $this->model->newQuery()
                ->with(['parents' => function($query) {
                    return $query->with(['parents' => function ($query) {
                        return $query->where('active', 1)
                            ->with('translation', function ($query) {
                                return $query->select(['category_id', 'name', 'description']);
                            })
                            ->select(['id', 'parent_id', 'slug']);
                    }, 'translation' => function ($query) {
                        return $query->select(['category_id', 'name', 'description']);
                    }])
                        ->where('active', 1)
                        ->select(['id', 'parent_id', 'slug']);
                }, 'translation' => function ($query) {
                    return $query->select(['category_id', 'name', 'description']);
                }])
                ->whereNull('parent_id')
                ->where('active', 1)
                ->select(['id', 'slug'])
                ->get();
            return $this->generateCategoriesFormat($categories);
        });
    }

    /**
     * @param $categories
     * @param int $level
     * @return array
     */
    public function generateCategoriesFormat($categories, int $level = 1) {
        $return = [];
        foreach ($categories as $category) {
            $return[] = [
                'id' => $category->id,
                'slug' => $category->slug,
                'name' => $category->translation->name ?? '',
                'children' => ($level < 3) ? $this->generateCategoriesFormat($category->parents, $level+1) : []
            ];
        }
 
        return $return;
    }

    /**
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
                if (!empty($category['children'])) {
                    foreach ($category['children'] as $child) {
                        $return[$category['slug']]['ids'][] = $child['id'];
                        $return[$category['slug']]['children'][$child['slug']] = [
                            'id' => $child['id'],
                            'name' => $child['name'],
                            'parent' => [
                                'id' => $category['id'],
                                'slug' => $category['slug'],
                                'name' => $category['name'],
                            ],
                            'ids' => [$child['id']]
                        ];
                        
                        if (!empty($child['children'])) {
                            foreach ($child['children'] as $child1) {
                                $return[$category['slug']]['ids'][] = $child1['id'];
                                $return[$category['slug']]['children'][$child['slug']]['ids'][] = $child1['id'];
                                $return[$category['slug']]['children'][$child['slug']]['children'][$child1['slug']] = [
                                    'id' => $child1['id'],
                                    'name' => $child1['name'],
                                    'parent' => [
                                        'id' => $child['id'],
                                        'slug' => $child['slug'],
                                        'name' => $child['name'],
                                    ],
                                    'ids' => [$child1['id']]
                                ];
                            }
                        }
                    }
                }
            }
            $this->groupedIdsBySlug = $return;
        }
        return $this->groupedIdsBySlug;
    }

    /**
     * @return array
     */
    public function getGroupedCategoriesIds(): array
    {
        if (!isset($this->categoriesFilterIds)) {
            $categories = $this->getCachedMenuCategoriesList();
            foreach ($categories as $category) {
                $this->categoriesFilterIds[$category['id']] = [$category['id']];
                if (!empty($category['children'])) {
                    foreach ($category['children'] as $child) {
                        $this->categoriesFilterIds[$category['id']][] = $child['id'];
                        $this->categoriesFilterIds[$child['id']] = [$child['id']];
                        if (!empty($child['children'])) {
                            foreach ($child['children'] as $child1) {
                                $this->categoriesFilterIds[$category['id']][] = $child1['id'];
                                $this->categoriesFilterIds[$child['id']][] = $child1['id'];
                                $this->categoriesFilterIds[$child1['id']] = [$child1['id']];
                            }
                        }
                    }
                }
            }
        }
        return $this->categoriesFilterIds;
    }
}
