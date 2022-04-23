<?php

namespace App\Domains\Stream\Models;

use App\Domains\Stream\Models\Traits\Attribute\LessonAttribute;
use App\Domains\Stream\Models\Traits\Relationship\LessonRelationship;
use App\Domains\Stream\Models\Traits\Scope\LessonScope;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Lesson extends Model
{
    use AsSource, LessonRelationship, LessonAttribute, LessonScope;

    protected $fillable = [
        "stream_id",
        "title",
        "slug",
        "sort",
        "attachment_id",
        "description",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected $casts = [
        "created_at" => "date",
    ];

    public $table = 'stream_lessons';

    public function saveComponents(array $components)
    {
        foreach ($components as $componentKey => $fields) {
            $component_id = preg_replace("/[^0-9]/", '', $componentKey);
            
            $component_model = LessonComponent::find($component_id);
            if (!$component_model) {
                continue;
            }

            if (isset($fields['media'])) {
                foreach ($fields['media'] as $key => $value) {
                    $model = LessonMedia::updateOrCreate([
                        "component_id" => $component_id,
                        "attachment_id" => $value,
                    ]);
                    $fields['media'][$key] = $model->id;
                }
            }

            $sort = $fields['sort'];
            unset($fields['sort']);

            $component_model->fill([
                "sort" => $sort,
                "fields" => $fields,
            ]);
            $component_model->save();
        }
    }
}
