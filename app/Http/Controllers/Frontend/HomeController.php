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

        // Extract reviews from services to show in social square
        $allReviews = [];
        foreach ($services as $service) {
            foreach ($service->reviews ?? [] as $rev) {
                $allReviews[] = [
                    'type' => 'review',
                    'name' => $rev['name'] ?? 'Parent Review',
                    'text' => $rev['text'] ?? '',
                    'stars' => $rev['stars'] ?? 5,
                    'image' => $service->resolveImageUrl($service->image),
                    'images' => $service->galleryImageUrls() ?: [$service->resolveImageUrl($service->image)],
                ];
            }
        }

        // Add some default social posts if reviews are few, to keep the visual grid rich
        $socialPosts = [
            [
                'type' => 'social',
                'name' => 'New Arrival: Round Crib',
                'text' => 'Our signature round crib is back in stock! Crafted with love and safety in mind. #LumosNursery #BabyRoom',
                'stars' => 0,
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=600',
                'images' => ['https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200'],
            ],
            [
                'type' => 'social',
                'name' => 'Wall Motifs Collection',
                'text' => 'Create a magical atmosphere with our custom backlit wall motifs. Available in moon, stars, and cloud designs.',
                'stars' => 0,
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600',
                'images' => ['https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200'],
            ],
            [
                'type' => 'social',
                'name' => 'Minimalist Nursery',
                'text' => 'Sometimes less is more. Our minimalist white-and-wood collection is perfect for modern homes. #MinimalistNursery #InteriorDesign',
                'stars' => 0,
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600',
                'images' => ['https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200'],
            ]
        ];

        // Interleave reviews and social posts
        $gridItems = [];
        $maxItems = max(count($allReviews), count($socialPosts));
        for ($i = 0; $i < $maxItems; $i++) {
            if (isset($allReviews[$i])) {
                $gridItems[] = $allReviews[$i];
            }
            if (isset($socialPosts[$i])) {
                $gridItems[] = $socialPosts[$i];
            }
        }

        // Limit grid items to 10 for grid symmetry
        $gridItems = array_slice($gridItems, 0, 10);

        return view('frontend.home', compact('products', 'services', 'homeSlides', 'gridItems'));
    }
}
