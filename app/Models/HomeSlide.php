<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    protected $fillable = [
        'kicker',
        'title',
        'subtext',
        'image',
        'button_text',
        'button_link',
        'sort_order',
    ];
}
