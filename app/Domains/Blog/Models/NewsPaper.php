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
        "category_id",
        "publication_date",
        "attachment_id",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "detail_attachment_id"
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
            
            // Log::info($fields);
            $component_model = NewsPaperComponent::find($component_id);
            if(!$component_model)
                continue;

            if(isset($fields['media'])){
                foreach ($fields['media'] as $key => $value) {
                    // $attach = Attachment::find($value);
                    
                    // // (берется слаг товара и используется в качестве имени)
                    // if(!Str::contains($attach->name, $this->slug)){
                        
                    //     $current_path = $attach->physicalPath();
                    //     do {
                    //         $name = $this->slug . '-' . random_int(0, 1000);
                    //         $find = Attachment::where('name' , $name)->first();
                    //     } while ($find);
                    //     $attach->fill(['name' => $name, 'original_name' => $name])->save();
                        
                    //     // на боевом можно использовать вариацию с move, а не copy,
                    //     // но сейчас нужен copy, т.к. при посеве изображений иногда изображения дублируются 
                    //     // Storage::disk('public')->move($current_path, $attach->physicalPath());
                    //     if(!Storage::disk('public')->exists($attach->physicalPath()))
                    //         Storage::disk('public')->copy($current_path, $attach->physicalPath());
                        
                    // }

                    $model = NewsPaperMedia::updateOrCreate([
                        "component_id" => $component_id,
                        "attachment_id" => $value
                    ]);
                    $fields['media'][$key] = $model->id;

                }
            }

            $sort = $fields['sort'];
            unset($fields['sort']);

            NewsPaperComponent::updateOrCreate([
                "news_paper_id" => $this->id,
                "id" => $component_id
            ],[
                "sort" => $sort,
                "fields" => $fields
            ]);
            
        }
    }

}
