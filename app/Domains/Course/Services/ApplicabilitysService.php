<?php

namespace App\Domains\Product\Services;


use App\Domains\Applicability\Models\Applicability;
use App\Domains\Applicability\Models\ApplicabilityTranslation;
use App\Exceptions\NoPageException;
use App\Services\BaseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class ApplicabilitysService extends BaseService
{
    /**
     * @var array
     */
    protected array $groupedIdsBySlug;

    /**
     * @var array
     */
    protected array $categoriesFilterIds;

    /**
     * __construct
     *
     * @param  Applicabilitys $applicability
     * @return void
     */
    public function __construct(Applicability $applicability)
    {
        $this->model = $applicability;
    }

    public function save(array $fields): self
    {
        $this->model->fill($fields);

        if (isset($fields['active'])) $this->model->active = true;
        else $this->model->active = false;

        $this->model->save();

        return $this;
    }
    public function saveTranslations(array $translations): self
    {

        foreach ($translations as $locale => $fields) {
            $entity = $this->model->translations->where('locale', $locale)
                ->first();
            if ($entity) {
                $entity->fill($fields)->save();
            } else {
                $fields['applicability_id'] = $this->model->id;
                $fields['locale'] = $locale;
                ApplicabilityTranslation::create($fields);
            }
        }

        return $this;
    }

    public function saveImages(array $images)
    {
        if (!isset($images['attachment_id'])) $images['attachment_id'] = [];
        foreach ($images as $key => $items) {
            foreach ($items as $item) {
                if ($item != null) {
                    $this->attachmentId($item);
                }
                Applicability::Where('id', $this->model->id)->update([$key => $item]);
            }
        }
    }

    public function saveTemplates(array $translations): self
    {
        foreach ($translations as $locale => $translation) {
            $entity = $this->model->translations->where('locale', $locale)->first();
            if ($entity) {
                $entity->fill($translation['templates'])->save();
            }
        }
        return $this;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getBySlug(string $slug)
    {
        return Applicability::query()
            ->where('slug', $slug)
            ->first();
    }

    private function attachmentId(int $attachment_id)
    {
        $attach = Attachment::find($attachment_id);

        // проверка на соответствие имени стандартам #68165 
        // https://b24.ac-step.com/workgroups/group/86/tasks/task/view/68165/

        // (берется слаг товара и используется в качестве имени)
        if (!Str::contains($attach->name, $this->model->name)) {

            $current_path = $attach->physicalPath();
            do {
                $name = $this->model->name . '-' . random_int(0, 100);
                $find = Attachment::where('name', $name)->first();
            } while ($find);
            $attach->fill(['name' => $name, 'original_name' => $name])->save();

            // на боевом можно использовать вариацию с move, а не copy,
            // но сейчас нужен copy, т.к. при посеве изображений иногда изображения дублируются 
            // Storage::disk('public')->move($current_path, $attach->physicalPath());
            if (!Storage::disk('public')->exists($attach->physicalPath()))
                Storage::disk('public')->copy($current_path, $attach->physicalPath());
        }
        return;
    }

    public function getAside()
    {
        $result = Applicability::where('active', 1)->get();
        
        $applicabilitys = [];
        foreach ($result as $item) {
                $applicabilitys[] = [
                    'slug' => $item['slug'],
                    'name' => $item->translation ? $item->translation->name : '-',
                    'image' => ($item->attachment) ? $item->attachment->url() : '/img/png/photo_not_found.png',
                ];
        }
        return $applicabilitys;
    }

    
}
