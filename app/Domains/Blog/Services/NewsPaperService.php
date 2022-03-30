<?php
namespace App\Domains\Blog\Services;

use App\Domains\Blog\Models\Category;
use App\Domains\Blog\Models\NewsPaper;
use App\Domains\Blog\Models\NewsPaperTag;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsPaperService extends BaseService
{

    /**
     * @var array|string[]
     */
    protected array $filtersTypes = [
        
    ];
    
    protected array $selectedFilters = [];

    /**
     * __construct
     *
     * @param  NewsPaper $product
     * @return void
     */
    public function __construct(NewsPaper $paper)
    {
        $this->query = NewsPaper::query()->where('active', true);

        $this->model = $paper;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return NewsPaper::query()
            ->where('slug', $slug)->where('active', true)
            ->first();
    }

    /**
     * Get list of selected filters
     * @return array
     */
    public function getSelectedFilters(): array
    {
        return $this->selectedFilters;
    }

    /**
     * @param string $filters
     * @param string $slug
     * @param int $page
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticles(string $filters, int $page, int $perPage = 9)
    {
        $this->attachFilters($filters);

        $query = $this->model->active();

        return $query->where('active', true)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }
    
    /**
     * @param $slug
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function showArticleDetails($slug)
    {
        $news_paper = $this->model->where('slug', $slug)->where('active', true)->with('components')->get()->first();
        if (!$news_paper)
            return null;

        return [$news_paper, $news_paper->components];
    }

    /**
     * Attach all filters
     * @param $filters
     */
    public function attachFilters($filters)
    {
        foreach ($this->parseFilters($filters) as $key => $value) {
            $method = $this->getFunctionName($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    /**
     * Get function name
     * @param string $key
     * @return string
     */
    protected function getFunctionName(string $key) {
        return Str::camel('filter' . Str::ucfirst($key));
    }

    /**
     * @param string $filters
     * @param bool $parseKey
     * @return array
     */
    public function parseFilters(string $filters, bool $parseKey = true): array
    {
        $return = [];
        foreach (explode(';', $filters) as $filter) {
            $filterArray = explode('=', $filter);
            if (empty($filterArray[1])) {
                continue;
            }
            $return[$filterArray[0]] = $this->parseValue($filterArray[0], $filterArray[1]);
        }

        return $return;
    }

    /**
     * Parse value
     * @param string $key
     * @param string $value
     * @return float|string|string[]
     */
    protected function parseValue(string $key, string $value)
    {
        $type = $this->filtersTypes[$key];
        switch ($type) {
            case 'array':
                return explode(',', $value);
            case 'float':
                return (float) $value;
            case 'int':
                return (int) $value;
            default:
                return $value;
        }
    }

}
