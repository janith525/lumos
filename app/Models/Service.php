<?php

namespace App\Models;

use App\Models\Concerns\HasGalleryImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;
    use HasGalleryImages;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'subtitle',
        'description',
        'status',
        'image',
        'images',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'og_image',
        'reviews',
        'project_timeline',
        'consultation_fee',
        'inclusions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_featured' => 'boolean',
            'reviews' => 'array',
            'inclusions' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_service')->withTimestamps();
    }

    public function ogImageUrl(): ?string
    {
        return static::resolveImageUrl($this->og_image) ?: $this->primaryImageUrl();
    }
}
