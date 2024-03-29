<?php

namespace App\Domains\Online\Services;

use App\Services\BaseService;
use App\Domains\Online\Models\Online;
use App\Exceptions\NoPageException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class OnlineService extends BaseService
{
    public const DEFAULT_LIMIT = 8;

    // кол-во элементов на странице
    protected int $currentLimitPage;
    // значение по умолчанию
    protected int $defaultLimitPage = self::DEFAULT_LIMIT;

    /**
     * __construct
     *
     * @param  Online $podcast
     * @return void
     */
    public function __construct(Online $podcast)
    {
        $this->model = $podcast;
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

        Cache::tags(['onlines'])->flush();

        return $this;
    }

    /**
     * Set default limit pagination
     */
    protected function attachLimitPagination()
    {
        $this->currentLimitPage = $this->defaultLimitPage;
    }

     /**
     * Get onlines catalog
      *
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCatalog(string $category = '', int $page = 1)
    {
        $builder = $this->model->active();

        if (!empty($category)) {
            $builder->where('type', $category);
        }

        $this->attachLimitPagination();

        $result = $builder->paginate($this->currentLimitPage, ['*'], 'page', $page);
        
        return $result;
    }

    /**
     * Информация по онлайн-курсу
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->where('active', true)->with(['components', 'stream'])->first();
    }
}
