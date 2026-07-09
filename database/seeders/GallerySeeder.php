<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'Royal Pastel Nursery',
                'subtitle' => 'Completed Nursery | Colombo 07',
                'category' => 'nursery',
                'image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Dilani S. (Colombo 07)',
                'review_content' => 'Absolutely in love with the Royal Pastel Nursery. The organic wood finish is incredibly safe, and the round crib is the centerpiece of the room!',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Starry Constellation Board',
                'subtitle' => 'Custom Backlit Decor',
                'category' => 'backdrop',
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Our signature backlit constellation board uses warm, baby-safe low-voltage LED lights to create a soothing, calm sleep environment.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Bespoke Organic Crib',
                'subtitle' => 'Child-Safe Ergonomic Furniture',
                'category' => 'furniture',
                'image' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Kavinda W. (Kandy)',
                'review_content' => 'The rounded edges on all furniture give us total peace of mind. Exceptional craftsmanship by the Lumos team!',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Montessori House Suite',
                'subtitle' => 'Interactive Play Area',
                'category' => 'playroom',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Fostering ultimate creativity and independence. Our Montessori house beds are built from solid non-toxic hardwood.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Safari Theme Baby Room',
                'subtitle' => 'Theme Development | Negombo',
                'category' => 'nursery',
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Nalaka P. (Negombo)',
                'review_content' => 'The custom jungle wall vinyls and matching cotton rugs completely changed the nursery atmosphere. Absolutely premium!',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => true,
                'sort_order' => 5
            ],
            [
                'title' => 'Soft-Close Storage Chest',
                'subtitle' => 'Premium Baby Proofing',
                'category' => 'furniture',
                'image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Organize with absolute style. Soft-close hinges and completely round edges ensure ultimate baby-proofing.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => true,
                'sort_order' => 6
            ],
            [
                'title' => 'Cloud Backdrop Motifs',
                'subtitle' => 'Backlit Soft Lighting',
                'category' => 'backdrop',
                'image' => 'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Ruwanthi D. (Rajagiriya)',
                'review_content' => 'Our little girl stares at the cloud backdrop every single evening before sleeping. It is so soothing!',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => true,
                'sort_order' => 7
            ],
            [
                'title' => 'Interactive Reading Teepee',
                'subtitle' => 'Interactive Play corners',
                'category' => 'playroom',
                'image' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Combining high-density soft foam padding with premium washed-cotton linens for the ultimate interactive play corner.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => true,
                'sort_order' => 8
            ],
            [
                'title' => 'Bespoke Changing Chest',
                'subtitle' => 'Multi-Functional Furniture',
                'category' => 'furniture',
                'image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Mahela J. (Battaramulla)',
                'review_content' => 'Highly functional changing drawer system with premium rounded dividers. Best investment we made!',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => true,
                'sort_order' => 9
            ],
            [
                'title' => 'Boho Warm-Neutral Room',
                'subtitle' => 'Natural Aesthetics Setup',
                'category' => 'nursery',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Crafted with natural materials, light oak woods, and high-quality premium linen fabrics for ultimate child safety.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => true,
                'sort_order' => 10
            ],
            [
                'title' => 'Constellation Ceiling Panels',
                'subtitle' => 'Backlit Ceiling Motifs',
                'category' => 'backdrop',
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => 'Kanishka D. (Nugegoda)',
                'review_content' => 'Lumos backlit ceiling motifs act as a beautiful soft nightlight, helping our baby settle into a deep sleep.',
                'stars' => 5,
                'type' => 'review',
                'show_on_home' => false,
                'sort_order' => 11
            ],
            [
                'title' => 'Padded Play Gym',
                'subtitle' => 'Child-Safe Playroom suite',
                'category' => 'playroom',
                'image' => 'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=600',
                'images' => [
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200'
                ],
                'review_author' => null,
                'review_content' => 'Safe, fun, and fully sanitizable. Custom padded flooring and activity centers designed with high-density premium foams.',
                'stars' => 0,
                'type' => 'social',
                'show_on_home' => false,
                'sort_order' => 12
            ]
        ];

        foreach ($items as $item) {
            GalleryItem::create($item);
        }
    }
}
