<?php
namespace App\Domains\Product\Services;

use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Models\RefCharsTranslation;
use App\Domains\Product\Models\RefCharsValue;
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


    public function saveTranslations(array $translations): self
    {
        foreach ($translations as $locale => $fields) {
            RefCharsTranslation::updateOrCreate([
                'char_id' => $this->model->id,
                'locale' => $locale
            ], [
                'name' => $fields['name']
            ]);
        }
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

        foreach ($values as $slug => $fields) {
            foreach (['ru', 'uk'] as $locale) {
                if ($fields['slug'] != "") {
                    RefCharsValue::updateOrCreate([
                        'char_id' => $this->model->id,
                        'slug' => $slug,
                        'locale' => $locale
                    ], [
                        'value' => $fields[$locale],
                        'slug' => $fields['slug'],
                        'rgb' => $fields['rgb'],
                    ]);
                }
            }
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCharsGroupedBySlug()
    {
        return Cache::tags('chars_with_values')->rememberForever('chars' . app()->getLocale(), function() {
            $chars = RefChar::query()
                ->with([
                    'values' => function ($query) {
                        return $query->where('locale', app()->getLocale());
                    },
                    'translation'
                ])
                ->where('type', 'property')
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
                    'translation' => [
                        'locale' => $char->translation->locale,
                        'name' => $char->translation->name
                    ]
                ];
            }
            return $return;
        });
    }
}
