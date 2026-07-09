<?php

namespace App\Models;

use App\Models\Concerns\HasGalleryImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;
    use HasGalleryImages;

    protected $fillable = [
        'title',
        'subtitle',
        'category',
        'image',
        'images',
        'review_author',
        'review_content',
        'stars',
        'type',
        'show_on_home',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'show_on_home' => 'boolean',
            'stars' => 'integer',
            'sort_order' => 'integer',
        ];
    }
}
