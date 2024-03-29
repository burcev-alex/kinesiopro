<?php

namespace App\Domains\Blog\Models;

use App\Domains\Blog\Models\Traits\Attribute\NewsPaperAttribute;
use App\Domains\Blog\Models\Traits\Relationship\NewsPaperRelationship;
use App\Domains\Blog\Models\Traits\Scope\NewsPaperScope;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class NewsPaper extends Model
{
    use AsSource, NewsPaperRelationship, NewsPaperAttribute, NewsPaperScope;

    protected $fillable = [
        "title",
        "slug",
        "publication_date",
        "attachment_id",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "detail_attachment_id",
    ];

    protected $casts = [
        "created_at" => "date",
        "publication_date" => "date",
    ];

    public $table = 'blog_news_papers';

    public function saveComponents(array $components)
    {
        foreach ($components as $componentKey => $fields) {
            $component_id = preg_replace("/[^0-9]/", '', $componentKey);
            
            $component_model = NewsPaperComponent::find($component_id);
            if (!$component_model) {
                continue;
            }

            if (isset($fields['media'])) {
                foreach ($fields['media'] as $key => $value) {
                    $model = NewsPaperMedia::updateOrCreate([
                        "component_id" => $component_id,
                        "attachment_id" => $value,
                    ]);
                    $fields['media'][$key] = $model->id;
                }
            }

            $sort = $fields['sort'];
            unset($fields['sort']);

            NewsPaperComponent::updateOrCreate([
                "news_paper_id" => $this->id,
                "id" => $component_id
            ], [
                "sort" => $sort,
                "fields" => $fields,
            ]);
        }
    }
}
