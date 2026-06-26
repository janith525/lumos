<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasGalleryImages
{
    public static function resolveImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset('storage/'.$path);
    }

    /**
     * @return list<string>
     */
    public function galleryImageUrls(): array
    {
        $paths = [];

        if ($this->image) {
            $paths[] = $this->image;
        }

        foreach ($this->images ?? [] as $image) {
            if (is_string($image) && $image !== '') {
                $paths[] = $image;
            }
        }

        $paths = array_values(array_unique($paths));

        return array_values(array_filter(array_map(
            fn (string $path): ?string => static::resolveImageUrl($path),
            $paths
        )));
    }

    public function primaryImageUrl(): ?string
    {
        return $this->galleryImageUrls()[0] ?? null;
    }

    public function imageUrl(): ?string
    {
        return $this->primaryImageUrl();
    }
}
