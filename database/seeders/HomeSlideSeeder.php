<?php

namespace Database\Seeders;

use App\Models\HomeSlide;
use Illuminate\Database\Seeder;

class HomeSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'kicker' => 'Nursery Styling',
                'title' => 'Lumos Nursery Space Design',
                'subtext' => 'Tiny Dreams: Sri Lanka\'s Pioneer Luxury Nursery Design & Kids Interior Studio.',
                'image' => 'hero/hero-1-desktop.jpeg',
                'mobile_image' => 'hero/hero-1-mobile.jpeg',
                'button_text' => 'Our Services',
                'button_link' => '#services',
                'sort_order' => 0,
            ],
            [
                'kicker' => 'Bespoke Craft',
                'title' => 'Bespoke Kids Furniture Collection',
                'subtext' => 'Round cribs, changing chests, and playhouse beds handcrafted with organic beechwood.',
                'image' => 'hero/hero-2-desktop.jpeg',
                'mobile_image' => 'hero/hero-2-mobile.jpeg',
                'button_text' => 'View Products',
                'button_link' => '#furniture',
                'sort_order' => 1,
            ],
        ];

        HomeSlide::truncate();

        foreach ($slides as $slide) {
            HomeSlide::updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }
    }
}
