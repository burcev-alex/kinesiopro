<?php

namespace App\Domains\Podcast\Services;

use App\Services\BaseService;
use App\Domains\Podcast\Models\Podcast;
use App\Exceptions\NoPageException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class PodcastService extends BaseService
{


    public const DEFAULT_LIMIT = 10;

    // кол-во элементов на странице
    protected int $currentLimitPage;
    // значение по умолчанию
    protected int $defaultLimitPage = self::DEFAULT_LIMIT;

    /**
     * __construct
     *
     * @param  Podcast $podcast
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->model = $podcast;
    }

    public function save(array $fields): self
    {
        $this->model->fill($fields['podcast']);
        if (isset($fields['podcast']['active'])) $this->model->active = true;
        else $this->model->active = false;


        $this->model->save();

        return $this;
    }

    public function saveImages(array $images)
    {
        
        if(!isset($images['attachment_id'])) $images['attachment_id'] = [];        
        
        foreach($images as $key => $items){
            foreach($items as $item){
                Podcast::where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }

    /**
     * Set default limit pagination
     */
    protected function attachLimitPagination()
    {
        $this->currentLimitPage = $this->defaultLimitPage;
    }

     /**
     * Get podcasts catalog
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCatalog(int $page = 1)
    {  
        $builder = $this->query->with('attachment');

        $result = $builder->paginate($this->currentLimitPage, ['*'], 'page', $page);
        
        return $result;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->where('active', true)->first();
    }
}
