<?php
namespace App\Domains\Product\Services;

use App\Domains\Product\Models\Product;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    /**
     * __construct
     *
     * @param  Product $product
     * @return void
     */
    public function __construct(Product $product) {
        $this->model = $product;
    }

    /**
     * whereSlug
     *
     * @param  string $slug
     * @return Product
     * @throws NoPageException
     */
    public function whereSlug(string $slug) : Product
    {
        $model = $this->where('slug', $slug)->get()->first();
        if($model === null){
            throw new NoPageException('there is no product with slug like: ' . $slug);
        }

        return $model;
    }

    /**
     * Todo move it to cache
     * @return int
     */
    public function getTotalActiveProducts(): int
    {
        return $this->model->newQuery()
            ->where('active', 1)
            ->count();
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function show(string $slug)
    {
        $builder = $this->model->newQuery()
            ->where('active', 1)
            ->where('slug', $slug)
            ->with([
                'images' => function ($query) {
                    return $query->with('attachment');
                },
                'translation',
                'local_property_values' => function ($query) {
                    return $query->with('chars', function ($query) {
                        return $query->with('translation')
                            ->where('active', 1);
                    });
                },
                'variants' => function ($query) {
                    return $query->with('images', function ($query) {
                        return $query->with('attachment');
                    });
                },
            ])->get();
            
        if($builder->count() > 0){
            return $builder->first();
        }
        else{
            return false;
        }
    }

    /**
     * Get products list for cart
     * @param array $productIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getProductsForCart(array $productIds)
    {
        return $this->model->newQuery()
            ->whereIn('id', $productIds)
            ->with([
                'local_property_values' => function ($query) {
                    return $query->with('chars', function ($query) {
                        return $query->with('translation')
                            ->where('active', 1);
                    });
                },
                'variants'
            ])->get();
    }

    /**
     * Get products list for cart
     * @param array $productIds
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getProductsForCartTotals(array $productIds)
    {
        return $this->model->newQuery()
            ->whereIn('id', $productIds)
            ->with([
                'variants'
            ])->get();
    }

    /**
     * @param $groupId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getProductsByGroupId($groupId)
    {
        return $this->model->newQuery()
            ->with([
                'image' => function ($query) {
                    return $query->with('attachment');
                },
                'translation',
                'variants'
            ])
            ->where('group_id', $groupId)
            ->get();
    }

    /**
     * @param int $groupId
     * @param int $categoryId
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSimilarProductsByCategoryId($course_id,$productCategories, int $count = 10)
    {
        $categories = [];
        foreach($productCategories as $category){
            $categories[] = $category->category_id;
        }
        
        $products = $this->model->newQuery()
            ->select('course_id as id','products.*')
            ->leftJoin('products_category', 'products_category.course_id', '=', 'products.id')
            ->with([
                'image' => function ($query) {
                    return $query->with('attachment');
                },
                'translation'
            ])
            ->whereIn('category_id', $categories)
            ->distinct()
            ->where('marker_archive', '!=', 1)
            ->where('active', '=', 1)
            ->where('course_id', '!=', $course_id)
            ->limit($count)
            ->orderByRaw('course_id ASC')
            ->get();
        return $products;
    }

    /**
     * @param int $productId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getProductVariantsById(int $productId)
    {
        return $this->model->newQuery()
            ->with([
                'translation',
                'variants'
            ])
            ->find($productId);
    }

    /**
     * @param string $typeName
     * @param bool $typeValue
     * @param int $count
     * @return array
     */
    public function getProductsByType(string $typeName, bool $typeValue = true, int $count = 6)
    {
        return $this->getProductsByFilters([
            $typeName => $typeValue
        ], [
            'column' => 'id'
        ], [
            'per_page' => $count
        ], [
            'image',
            'translation'
        ])->items();
    }

    /**
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductsByFilters(array $filters = [], array $orders = [], array $pagination = [], array $with = [])
    {
        $model = $this->newQuery()
            ->with($with);
        if ($filters) {
            foreach ($filters as $key => $value) {
                $model = $model->where($key, $value);
            }
        }

        return $model->orderBy(
            $orders['column'] ?? 'created_at',
            $orders['direction'] ?? 'desc'
        )->paginate($pagination['per_page'] ?? 5, ['*'], 'page', $pagination['page'] ?? 1);
    }
}
