<?php
namespace App\Domains\Course\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\CourseBlock;
use App\Domains\Course\Models\CourseDesciptionComponent;
use App\Domains\Course\Models\CourseDesciptionMedia;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\CourseTeacher;
use App\Domains\Course\Models\RefCharsValue;
use App\Domains\Course\Services\CourseService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Orchid\Attachment\Models\Attachment;

class CourseOrchidService extends CourseService
{

    protected $group = null;

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

        Cache::tags(['courses'])->flush();
        
        return $this;
    }

    public function saveProperties(array $properties, $overwrite = true)
    {
        if ($overwrite) {
            // найти все значения характеристик
            $arrPropertyValues = [];
            $resCourseProperties = CourseProperty::where('course_id', $this->model->id)->with('ref_char')->get();
            foreach ($resCourseProperties as $propertyValue) {
                // если это изменения из группы ,
                // тогда НЕ редактировать поля Цена за пару и Размеры в ростовке
                if (! is_null($this->group)) {
                    if (! in_array($propertyValue->ref_char->slug, ['cvet'])) {
                        $arrPropertyValues[] = $propertyValue->ref_char_value_id;
                    }
                } else {
                    $arrPropertyValues[] = $propertyValue->ref_char_value_id;
                }
            }
            
            // найти пересечение и удалить те значения , которых нет в новом наборе
            foreach ($arrPropertyValues as $valueId) {
                if (! in_array($valueId, $properties)) {
                    $rsDeleteProperty = CourseProperty::where('course_id', $this->model->id)
                        ->where('ref_char_value_id', $valueId)->get();
                    foreach ($rsDeleteProperty as $property) {
                        $property->delete();
                    }
                }
            }
        }

        foreach ($properties as $char_value) {
            $ref_char_value = RefCharsValue::find($char_value);
            CourseProperty::updateOrCreate([
                'course_id' => $this->model->id,
                'ref_char_value_id' => $char_value,
            ], [
                'ref_char_id' => $ref_char_value->char_id,
            ]);
        }
        return $this;
    }

    public function saveBlocks(array $blocks, $overwrite = true)
    {
        if ($overwrite) {
            // удалить все старые блоки
            $rsDeleteBlock = CourseBlock::where('course_id', $this->model->id)->get();
            foreach ($rsDeleteBlock as $block) {
                $block->delete();
            }
        }

        foreach ($blocks as $block) {
            CourseBlock::create([
                'course_id' => $this->model->id,
                'title' => $block['title'],
                'sort' => $block['sort'],
                'start_date' => $block['start_date'],
                'finish_date' => $block['finish_date'],
                'teacher_id' => $block['teacher_id']
            ]);
        }
        return $this;
    }

    public function saveComponents(array $components)
    {
        foreach ($components as $componentKey => $fields) {
            $component_id = preg_replace("/[^0-9]/", '', $componentKey);
            
            $component_model = CourseDesciptionComponent::find($component_id);
            if (!$component_model) {
                continue;
            }

            if (isset($fields['media'])) {
                foreach ($fields['media'] as $key => $value) {
                    $model = CourseDesciptionMedia::updateOrCreate([
                        "component_id" => $component_id,
                        "attachment_id" => $value,
                    ]);
                    $fields['media'][$key] = $model->id;
                }
            }

            $sort = $fields['sort'];
            unset($fields['sort']);

            CourseDesciptionComponent::updateOrCreate([
                "course_id" => $this->model->id,
                "id" => $component_id
            ], [
                "sort" => $sort,
                "fields" => $fields,
            ]);
        }
    }

    public function saveTeachers(array $teachers, $overwrite = true)
    {
        if ($overwrite) {
            // удалить все старые записи
            $rsDeleteTeachers = CourseTeacher::where('course_id', $this->model->id)->get();
            foreach ($rsDeleteTeachers as $teacher) {
                $teacher->delete();
            }
        }

        foreach ($teachers['id'] as $teacher) {
            CourseTeacher::create([
                'course_id' => $this->model->id,
                'teacher_id' => intval($teacher),
            ]);
        }
        return $this;
    }

    public function saveMarkers(array $markers)
    {
        
        if (array_key_exists('marker_new', $markers)) {
            $this->model->marker_new = 1;
        } else {
            $this->model->marker_new = 0;
        }
        
        if (array_key_exists('marker_popular', $markers)) {
            $this->model->marker_popular = 1;
        } else {
            $this->model->marker_popular = 0;
        }
        
        if (array_key_exists('marker_archive', $markers)) {
            $this->model->marker_archive = 1;
        } else {
            $this->model->marker_archive = 0;
        }

        $this->model->save();
    }
}
