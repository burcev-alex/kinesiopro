<?php

namespace App\Domains\Feedback\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class FeedBack extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        "name",
        "phone",
    ];
}
