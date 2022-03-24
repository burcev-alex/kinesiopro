<?php
namespace App\Domains\Course\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Course\Models\CourseBlock;
use App\Domains\Course\Models\CourseProperty;
use App\Domains\Course\Models\RefCharsValue;
use App\Domains\Course\Services\CourseService;
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
        if(array_key_exists('teachers_list', $fields)){
            $fields['teacher_id'] = $fields['teachers_list'];
            unset($fields['teachers_list']);
        }
        
        $this->model->fill($fields)->save();
        $this->saveMarkers($fields);
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
                }
                else{
                    $arrPropertyValues[] = $propertyValue->ref_char_value_id;
                }
            }
            
            // найти пересечение и удалить те значения , которых нет в новом наборе
            foreach ($arrPropertyValues as $valueId) {
                if (! in_array($valueId, $properties)) {
                    $rsDeleteProperty = CourseProperty::where('course_id', $this->model->id)->where('ref_char_value_id', $valueId)->get();
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
                'ref_char_value_id' => $char_value
            ], [
                'ref_char_id' => $ref_char_value->char_id
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

    public function saveMarkers(array $markers)
    {
        $this->model->active = isset($markers['active']);
        $this->model->marker_new = isset($markers['marker_new']);
        $this->model->marker_popular = isset($markers['marker_popular']);
        $this->model->marker_archive = isset($markers['marker_archive']);

        $this->model->save();
    }
}
