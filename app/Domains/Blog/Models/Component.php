<?php

namespace App\Domains\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "fields"
    ];

    protected $casts = [
        'fields' => "array"
    ];

    public $table = 'blog_components';
    
}
