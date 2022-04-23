<?php
namespace App\Domains\Quiz\Services;

use App\Domains\Quiz\Models\Item;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuizItemService extends BaseService
{
    /**
     * __construct
     *
     * @param  Item $item
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->query = Item::query()->where('active', true);

        $this->model = $item;
    }

    /**
     * Даные по тесту
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Item::query()
            ->where('slug', $slug)->where('active', true)
            ->first();
    }

    /**
     * Список тестов
     *
     * @param string $filters
     * @param string $slug
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(int $page, int $perPage = 12)
    {
        $query = $this->model->active();

        return $query->where('active', true)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
    
    /**
     * Детальная информация по тесту
     *
     * @param $slug
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function showItemDetails($slug)
    {
        $rs = $this->model->where('slug', $slug)->where('active', true)->get()->first();
        if (!$rs) {
            return null;
        }

        return [$rs, $rs->questions];
    }
}
