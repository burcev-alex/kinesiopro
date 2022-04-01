<?php

namespace App\Domains\Quiz\Models;

use App\Domains\Quiz\Models\Traits\Attribute\ItemAttribute;
use App\Domains\Quiz\Models\Traits\Relationship\ItemRelationship;
use App\Domains\Quiz\Models\Traits\Scope\ItemScope;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ItemQuizFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory, AsSource, ItemRelationship, ItemAttribute, ItemScope;

    protected $fillable = [
        "title",
        "slug",
        "attachment_id",
        "detail_attachment_id",
        "preview",
        "description",
        "meta_title",
        "meta_keywords",
        "meta_description",
    ];

    protected $casts = [
        "created_at" => "date",
    ];

    public $table = 'quiz_items';

    public function saveQuestions(array $components)
    {
        foreach ($components as $componentKey => $fields) {
            $component_id = preg_replace("/[^0-9]/", '', $componentKey);
            
            $component_model = ItemQuestion::find($component_id);
            if(!$component_model)
                continue;

            $sort = $fields['sort'];
            unset($fields['sort']);

            ItemQuestion::updateOrCreate([
                "item_id" => $this->id,
                "id" => $component_id
            ],[
                "sort" => $sort,
                "fields" => $fields
            ]);
            
        }
    }

    protected static function newFactory()
    {
        return ItemQuizFactory::new();
    }
}
