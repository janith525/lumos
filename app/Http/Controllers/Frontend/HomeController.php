<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use App\Models\Product;
use App\Models\Service;

class HomeController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->where('status', 'published')
            ->where('show_on_home', true)
            ->orderBy('id', 'desc')
            ->get();

        $services = Service::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        $homeSlides = HomeSlide::query()
            ->orderBy('sort_order')
            ->get();

        // Fetch showcase gallery items selected for homepage
        $galleryItems = \App\Models\GalleryItem::query()
            ->where('show_on_home', true)
            ->orderBy('sort_order', 'asc')
            ->take(10)
            ->get();

        $gridItems = [];
        foreach ($galleryItems as $item) {
            $gridItems[] = [
                'type' => $item->type,
                'name' => $item->type === 'review' ? ($item->review_author ?? $item->title) : $item->title,
                'text' => $item->review_content ?? '',
                'stars' => $item->stars,
                'image' => $item->primaryImageUrl(),
                'images' => $item->galleryImageUrls() ?: [$item->primaryImageUrl()],
            ];
        }

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $title = $settings['home_meta_title'] ?? 'Lumos Nursery & Baby Room Interior Design Studio Sri Lanka';
        $description = $settings['home_meta_description'] ?? 'Lumos is Sri Lanka\'s first specialized luxury nursery design and kids interior studio. We create tiny dreams with bespoke cribs and safe spaces.';
        $keywords = $settings['home_meta_keywords'] ?? 'nursery design Sri Lanka, baby room interior Colombo, kids furniture, custom cribs';
        $og_image = !empty($settings['home_og_image']) ? (str_starts_with($settings['home_og_image'], 'http') ? $settings['home_og_image'] : asset('storage/' . $settings['home_og_image'])) : null;

        return view('frontend.home', compact('products', 'services', 'homeSlides', 'gridItems', 'title', 'description', 'keywords', 'og_image'));
    }
}
