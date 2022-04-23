<?php
namespace App\Domains\Online\Services;

use App\Domains\Online\Models\Online;
use App\Domains\Online\Models\OnlineDesciptionComponent;
use App\Domains\Online\Models\OnlineDesciptionMedia;
use App\Domains\Online\Services\OnlineService;
use Illuminate\Support\Facades\Cache;

class OnlineOrchidService extends OnlineService
{

    /**
     * Сохраняет личные поля модели
     *
     * @param  array $fields
     * @return self
     */
    public function save(array $fields): self
    {
        if (!isset($fields['active'])) {
            $fields['active'] = 0;
        } elseif (isset($fields['active'])) {
            $fields['active'] = 1;
        }
        
        $this->model->fill($fields)->save();

        Cache::tags(['onlines'])->flush();
        
        return $this;
    }

    public function saveComponents(array $components)
    {
        foreach ($components as $componentKey => $fields) {
            $component_id = preg_replace("/[^0-9]/", '', $componentKey);
            
            $component_model = OnlineDesciptionComponent::find($component_id);
            if (!$component_model) {
                continue;
            }

            if (isset($fields['media'])) {
                foreach ($fields['media'] as $key => $value) {
                    $model = OnlineDesciptionMedia::updateOrCreate([
                        "component_id" => $component_id,
                        "attachment_id" => $value,
                    ]);
                    $fields['media'][$key] = $model->id;
                }
            }

            $sort = $fields['sort'];
            unset($fields['sort']);

            OnlineDesciptionComponent::updateOrCreate([
                "online_id" => $this->model->id,
                "id" => $component_id
            ], [
                "sort" => $sort,
                "fields" => $fields,
            ]);
        }
    }
}
