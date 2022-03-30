<?php

namespace App\Domains\Online\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineDesciptionMedia extends Model
{
    protected $fillable = [
        "component_id",
        "attachment_id"
    ];

    public $table = 'onlines_description_media';
}
