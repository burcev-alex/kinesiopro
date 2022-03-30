<?php

namespace App\Domains\Online\Models;

use App\Domains\Online\Models\Traits\Attribute\OnlineDesciptionComponentAttribute;
use App\Domains\Online\Models\Traits\Relationship\OnlineDesciptionComponentRelationship;
use Illuminate\Database\Eloquent\Model;

class OnlineDesciptionComponent extends Model
{
    use OnlineDesciptionComponentAttribute, 
    OnlineDesciptionComponentRelationship;

    protected $fillable = [
        "course_id",
        "component_id",
        "sort",
        "fields"
    ];
    protected $casts = [
        "fields" => "array"
    ];

    public $table = 'onlines_description_components';

    
}
