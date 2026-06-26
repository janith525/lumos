<?php

namespace App\Models;

use App\Models\Concerns\HasGalleryImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasGalleryImages;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price', // pricing support
        'status',
        'highlights',
        'show_on_home',
        'meta_title',
        'meta_description',
        'og_image',
        'image',
        'images',
        'dimensions',
        'material',
        'safety_standards',
        'age_range',
        'lead_time',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'highlights' => 'array',
            'show_on_home' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'product_service')->withTimestamps();
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_related_products',
            'product_id',
            'related_product_id'
        )->withTimestamps();
    }

    public function ogImageUrl(): ?string
    {
        return static::resolveImageUrl($this->og_image) ?: $this->primaryImageUrl();
    }
}
