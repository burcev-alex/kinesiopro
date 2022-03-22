<?php

namespace App\Domains\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Log;
use Orchid\Attachment\Models\Attachment;

class NewsPaperComponent extends Model
{
    protected $fillable = [
        "news_paper_id",
        "component_id",
        "sort",
        "fields"
    ];
    protected $casts = [
        "fields" => "array"
    ];

    public $table = 'blog_news_paper_components';


    public function getMediaFieldsAttribute()
    {
        $fields = $this->fields;
        if(isset($fields['media']) && is_array(($fields['media'])))
        {
            foreach ($fields['media'] as $key => $value) {
                $media = NewsPaperMedia::find($value);
                $value = $media->attachment;
                $fields['media'][$key] = $value;
             }
        } else 
            unset($fields['media']);
        return $fields;
    }

    public function component()
    {
        return $this->hasOne(Component::class, 'id', 'component_id');
    }

    public function getNameAttribute()
    {
        return  $this->component->name;
    }
    public function getSlugAttribute()
    {
        return  $this->component->slug;
    }

}
