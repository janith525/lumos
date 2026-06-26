<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('product_service')->truncate();
        Service::truncate();

        Schema::enableForeignKeyConstraints();

        $services = [
            [
                'name' => 'Baby Nursery Space Design & Styling',
                'slug' => 'baby-nursery-design',
                'category' => 'Interior Design',
                'subtitle' => 'Bespoke, safe, and dreamy nursery sanctuaries constructed for deep sleep.',
                'description' => 'Our signature service. We consult, design, and assemble premium baby nursery spaces. We specialize in organic wood furniture positioning, soft non-toxic wall paddings, and soothing backlit celestial motifs that calm babies.',
                'image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200'
                ],
                'reviews' => [
                    [
                        'name' => 'Dilani S. (Colombo 07)',
                        'stars' => 5,
                        'text' => 'Absolutely in love with the Royal Pastel Nursery. The organic wood finish is incredibly safe, and the round crib is the centerpiece of the room!'
                    ],
                    [
                        'name' => 'Nalaka P. (Negombo)',
                        'stars' => 5,
                        'text' => 'The custom jungle wall vinyls and matching cotton rugs completely changed the nursery atmosphere. Absolutely premium!'
                    ]
                ],
                'project_timeline' => '3-4 Weeks',
                'consultation_fee' => 'LKR 15,000',
                'inclusions' => [
                    '3D Floor Plan Rendering',
                    'Safety & Lighting Assessment',
                    'Bespoke Furniture Customization'
                ],
                'is_featured' => true,
                'sort_order' => 1,
                'status' => 'published',
                'meta_title' => 'Baby Nursery Space Design & Styling | Lumos Nursery Studio',
                'meta_description' => 'Bespoke baby nursery styling and interior decoration in Sri Lanka. Designing safe, non-toxic, and dream room environments for deep sleep.',
                'og_image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&w=1200&q=80',
                'product_slugs' => ['royal-pastel-round-crib', 'premium-changing-chest'],
            ],
            [
                'name' => 'Interactive Kids Playroom Transformation',
                'slug' => 'kids-playroom-transformation',
                'category' => 'Interior Design',
                'subtitle' => 'Foster creativity and active play with non-toxic, padded playgrounds.',
                'description' => 'Turn any room into an interactive playroom. We custom-build Montessori house beds, reading teepees, soft activity gyms, and sensory toy cabinets with soft-close child-safe hardware.',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&q=80&w=1200'
                ],
                'reviews' => [
                    [
                        'name' => 'Kavinda W. (Kandy)',
                        'stars' => 5,
                        'text' => 'The rounded edges on all furniture give us total peace of mind. Exceptional craftsmanship by the Lumos team!'
                    ]
                ],
                'project_timeline' => '2-3 Weeks',
                'consultation_fee' => 'LKR 12,500',
                'inclusions' => [
                    'Sensory Corner Layout',
                    'Soft Gym Assembly',
                    'Montessori Furniture Placement'
                ],
                'is_featured' => true,
                'sort_order' => 2,
                'status' => 'published',
                'meta_title' => 'Interactive Kids Playroom Transformation | Lumos Nursery Studio',
                'meta_description' => 'Convert child bedrooms into creative, Montessori-friendly interactive playrooms. Handcrafted soft furniture, rounded safety edges.',
                'og_image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&w=1200&q=80',
                'product_slugs' => ['montessori-house-bed', 'scandinavian-storage-chest'],
            ],
            [
                'name' => 'Magical Backlit Wall Decor & Safety Consulting',
                'slug' => 'safety-decor-consultation',
                'category' => 'Safety & Lighting',
                'subtitle' => 'Baby-proof lighting and customizable wooden wall panels.',
                'description' => 'Sleep-inducing illumination panels. We mount backlit wooden constellation ceiling boards and cloud lighting motifs using low-voltage, baby-safe warm LEDs.',
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&q=80&w=1200',
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&q=80&w=1200'
                ],
                'reviews' => [
                    [
                        'name' => 'Ruwanthi D. (Rajagiriya)',
                        'stars' => 5,
                        'text' => 'Our little girl stares at the cloud backdrop every single evening before sleeping. It is so soothing!'
                    ],
                    [
                        'name' => 'Kanishka D. (Nugegoda)',
                        'stars' => 5,
                        'text' => 'Lumos backlit ceiling motifs act as a beautiful soft nightlight, helping our baby settle into a deep sleep.'
                    ]
                ],
                'project_timeline' => '1-2 Weeks',
                'consultation_fee' => 'LKR 8,000',
                'inclusions' => [
                    'LED Low-Voltage Circuit Design',
                    'Custom Constellation Board Layout',
                    'Child-Safe Mounting Verification'
                ],
                'is_featured' => true,
                'sort_order' => 3,
                'status' => 'published',
                'meta_title' => 'Magical Backlit Wall Decor & Safety Consulting | Lumos Nursery Studio',
                'meta_description' => 'Custom child-safe backlit wall and ceiling panels using warm LEDs. Professional safety consulting for newborn nurseries in Sri Lanka.',
                'og_image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
                'product_slugs' => ['backlit-constellation-board', 'cloud-backlit-motif'],
            ],
        ];

        foreach ($services as $data) {
            $productSlugs = $data['product_slugs'];
            unset($data['product_slugs']);

            $service = Service::create($data);

            $productIds = Product::query()
                ->whereIn('slug', $productSlugs)
                ->pluck('id');

            $service->products()->sync($productIds);
        }
    }
}
