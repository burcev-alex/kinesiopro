<?php

namespace App\Domains\Banner\Services;

use App\Services\BaseService;
use App\Domains\Banner\Models\Banner;
use Illuminate\Support\Facades\Cache;

class BannersService extends BaseService
{
    /**
     * __construct
     *
     * @param  Banner $banner
     * @return void
     */
    public function __construct(Banner $banner)
    {
        $this->model = $banner;
    }

    public function getHomeBanners()
    {
        return Cache::tags('banners')->rememberForever('banners.' . app()->getLocale(), function () {
            $result = Banner::Where('active', 1)->orderBy('sort', 'asc')->orderBy('created_at', 'desc')->get();
            $banners = [];
            
            foreach ($result as $item) {
                if ($item->attachment) {
                    $banners[] = [
                        'name' => $item->name,
                        'time_organization' => $item->time_organization,
                        'place' => $item->place,
                        'description' => $item->description,
                        'image' => $item->attachment->url(),
                        'image_webp' => $item->attachment_webp,
                        'image_mobile' => $item->attachment_mobile->url(),
                    ];
                }
            }

            return $banners;
        });
    }

    public function save(array $fields): self
    {
        $this->model->fill($fields['banner']);
        if (isset($fields['banner']['active'])) {
            $this->model->active = true;
        } else {
            $this->model->active = false;
        }

        $this->model->save();

        Cache::tags(['banners'])->flush();

        return $this;
    }

    public function saveImages(array $images)
    {
        
        if (!isset($images['attachment_id'])) {
            $images['attachment_id'] = [];
        }
        if (!isset($images['attachment_mobile_id'])) {
            $images['attachment_mobile_id'] = [];
        }
        
        foreach ($images as $key => $items) {
            foreach ($items as $item) {
                Banner::where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }
}
