<?php
namespace App\Domains\Stream\Services;

use App\Domains\Stream\Models\Stream;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StreamService extends BaseService
{

    /**
     * Construct
     *
     * @param  Stream $stream
     * @return void
     */
    public function __construct(Stream $stream)
    {
        $this->query = Stream::query()->where('active', true);

        $this->model = $stream;
    }

    /**
     * Данные по конкретному видео курсу
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Stream::query()
            ->where('slug', $slug)->where('active', true)
            ->first();
    }

    /**
     * Вывод списка новостей по фильтру
     *
     * @param string $filters
     * @param string $slug
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticles(string $filters, int $page, int $perPage = 9)
    {
        $query = $this->model->active();

        return $query->where('active', true)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
    
    /**
     * Детальная информация
     *
     * @param $slug
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function showArticleDetails($slug)
    {
        $stream = $this->model->where('slug', $slug)->where('active', true)->with('lessons')->get()->first();
        if (!$stream) {
            return null;
        }

        return [$stream, $stream->lessons];
    }
}
