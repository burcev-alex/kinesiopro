<?php
namespace App\Domains\Course\Services;

use App\Domains\Course\Models\RefChar;
use App\Domains\Course\Models\RefCharsValue;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;

class RefCharService extends BaseService
{
    /**
     * __construct
     *
     * @param  RefChar $product
     * @return void
     */
    public function __construct(RefChar $ref)
    {
        $this->model = $ref;
    }

    public function save(array $fields): self
    {
        $fields['active'] = isset($fields['active']) ? true : false;
        $fields['sort'] = isset($fields['sort']) ? $fields['sort'] : 100;
        $this->model->fill($fields)->save();
        return $this;
    }

    public function saveValues(array $values): self
    {
        // найти все значения характеристик
        $arrCharValues = [];
        $resCharProperties = RefCharsValue::where('char_id', $this->model->id)->get();
        foreach($resCharProperties as $charValue){
            $arrCharValues[] = $charValue->slug;
        }
        $arrCharValues = array_unique($arrCharValues);

        // найти пересечение и удалить те значения , которых нет в новом наборе
        foreach($arrCharValues as $valueId){
            if(!array_key_exists($valueId, $values)){
                $rsDeleteValues = RefCharsValue::where('char_id', $this->model->id)->where('slug', $valueId)->get();
                foreach($rsDeleteValues as $elValue){
                    $elValue->delete();
                }
            }
        }

        foreach ($values as $slug => $value) {
            if ($value != "") {
                RefCharsValue::updateOrCreate([
                    'char_id' => $this->model->id,
                    'slug' => $slug
                ], [
                    'value' => trim($value['value']),
                    'slug' => $slug
                ]);
            }
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCharsGroupedBySlug()
    {
        return Cache::tags('chars_with_values')->rememberForever('chars', function() {
            $chars = RefChar::query()
                ->with([
                    'values'
                ])
                ->where('active', 1)
                ->orderBy('sort', 'ASC')
                ->get()
                ->groupBy('slug')
                ->map(function ($query) {
                    return $query->first();
                });

            $return = [];
            foreach ($chars as $key => $char) {
                $return[$key] = [
                    'id' => $char->id,
                    'slug' => $char->slug,
                    'values' => $char->values->toArray(),
                    'name' => $char->name
                ];
            }
            return $return;
        });
    }
}
