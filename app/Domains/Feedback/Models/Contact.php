<?php

namespace App\Domains\Feedback\Models;

use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Contact extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        "city",
        "full_name",
        "url",
        "phone",
        "email",
        "address",
        "fb",
        "vk",
        "instagram",
        "youtube",
    ];

    protected $casts = [
        'phone' => 'array',
    ];
    

    protected static function newFactory()
    {
        return ContactFactory::new();
    }
}
