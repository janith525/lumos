<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('product_related_products')->truncate();
        DB::table('product_service')->truncate();
        Product::truncate();

        Schema::enableForeignKeyConstraints();

        $products = [
            [
                'name' => 'Royal Pastel Round Organic Crib',
                'slug' => 'royal-pastel-round-crib',
                'price' => 'LKR 125,000',
                'description' => '<p>The signature piece of Lumos. Handcrafted from safety-certified organic beechwood. Includes circular design that avoids all sharp corners, three height adjustments, and fully breathable safe slats.</p><h3>Key Features</h3><ul><li>360-degree safe circular design</li><li>3 adjustable mattress heights</li><li>Non-toxic organic finish</li></ul>',
                'highlights' => [
                    'Solid non-toxic hardwood crib with 360-degree safe slats',
                    'Zero sharp edges or corners for maximum child protection',
                    'Fitted with breathable safety fabrics',
                    'Certified safety standards by Lumos Studio'
                ],
                'dimensions' => '120 x 80 x 90 cm',
                'material' => 'Solid Beechwood & organic oils',
                'safety_standards' => 'EN 716-1 safety certified',
                'age_range' => '0 - 3 Years',
                'lead_time' => '4-6 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Royal Pastel Round Organic Crib | Lumos Nursery Studio',
                'meta_description' => 'Handcrafted round baby crib made from safety-certified organic beechwood. Safe, breathable, and elegant nursery centerpiece in Sri Lanka.',
                'og_image' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['premium-changing-chest', 'cloud-backlit-motif'],
            ],
            [
                'name' => 'Bespoke Changing & Wardrobe Chest',
                'slug' => 'premium-changing-chest',
                'price' => 'LKR 95,000',
                'description' => '<p>Beautiful, sleek changing drawer chest featuring rounded edges and premium dividers. Integrated soft-close sliders to prevent baby finger pinching.</p><h3>Key Features</h3><ul><li>Multi-functional changing top</li><li>Premium drawer dividers included</li><li>Pneumatic soft-close sliders</li></ul>',
                'highlights' => [
                    'Multi-functional storage unit with soft-close drawers',
                    'Rounded edges to eliminate bump hazards',
                    'Constructed from organic, child-safe plantation timber',
                    'Spacious drawers with customizable interior dividers'
                ],
                'dimensions' => '95 x 50 x 85 cm',
                'material' => 'Organic Plantation Timber',
                'safety_standards' => 'Anti-tip certified design',
                'age_range' => '0 - 6 Years',
                'lead_time' => '4-5 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Bespoke Changing & Wardrobe Chest | Lumos Nursery Studio',
                'meta_description' => 'Premium nursery changing and wardrobe drawer chest with soft-close mechanisms. 100% organic wood, child-safe construction.',
                'og_image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['royal-pastel-round-crib', 'scandinavian-storage-chest'],
            ],
            [
                'name' => 'Montessori Wooden House Bed',
                'slug' => 'montessori-house-bed',
                'price' => 'LKR 110,000',
                'description' => '<p>Nurturing childhood independence. Solid pine wood house frame bed that sits close to the floor to prevent baby falls. Eco-friendly organic oil finish.</p><h3>Key Features</h3><ul><li>Floor-flush frame configuration</li><li>Encourages independent exploration</li><li>High-grade solid pine structure</li></ul>',
                'highlights' => [
                    'Solid timber play bed that sits flush to floor for safety',
                    'Encourages kid independence following Montessori concepts',
                    'Smooth eco-friendly organic oil finish',
                    'Sturdy design supporting toddler active play'
                ],
                'dimensions' => '150 x 100 x 140 cm',
                'material' => 'High-grade Solid Pine',
                'safety_standards' => 'Floor-flush fall protection',
                'age_range' => '2 - 10 Years',
                'lead_time' => '5-7 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Montessori Wooden House Bed | Lumos Nursery Studio',
                'meta_description' => 'Floor-flush solid pine wood Montessori house bed. Child-safe structure promoting toddler independence and dream sleep.',
                'og_image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1596704017254-9b121068fb31?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['scandinavian-storage-chest', 'royal-pastel-round-crib'],
            ],
            [
                'name' => 'Scandinavian Soft-Close Toy Chest',
                'slug' => 'scandinavian-storage-chest',
                'price' => 'LKR 75,000',
                'description' => '<p>Elegant Scandinavian style toy cabinet. Fitted with specialized double anti-slam pneumatic dampers to protect baby hands from heavy lids.</p><h3>Key Features</h3><ul><li>Double pneumatic dampers</li><li>Sleek oak paneling</li><li>Ample space for large play accessories</li></ul>',
                'highlights' => [
                    'Chic, clean solid oak chest with safety anti-slam lid',
                    'Premium double dampers to protect baby hands',
                    'Spacious, minimalist Scandinavian playroom styling',
                    'Constructed using lead-free, non-toxic sealing stains'
                ],
                'dimensions' => '80 x 45 x 50 cm',
                'material' => 'Solid Oak paneling & Veneer',
                'safety_standards' => 'Anti-slam pneumatic dampers',
                'age_range' => '1 - 8 Years',
                'lead_time' => '3-4 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Scandinavian Soft-Close Toy Chest | Lumos Nursery Studio',
                'meta_description' => 'Chic solid oak toy storage box with anti-slam safety dampers. Keeps your nursery neat and your toddler hands secure.',
                'og_image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['montessori-house-bed', 'premium-changing-chest'],
            ],
            [
                'name' => 'Sleek Backlit Constellation Board',
                'slug' => 'backlit-constellation-board',
                'price' => 'LKR 45,000',
                'description' => '<p>A custom wood ceiling installation backlit with hundreds of tiny warm LED fiber optic stars. Dimmable and low-voltage for absolute safety.</p><h3>Key Features</h3><ul><li>Fiber optic star effect</li><li>Low-voltage (12V) LED circuitry</li><li>Wireless remote brightness controller</li></ul>',
                'highlights' => [
                    'Baby-safe LED night sky ceiling installation',
                    'Generates a soothing sleep-promoting environment',
                    'Certified low-voltage warm lights with zero fire risks',
                    'Customizable constellations to match your kid\'s birthday star sign'
                ],
                'dimensions' => '120 x 120 x 5 cm',
                'material' => 'Lightweight Baltic Birch & fiber optics',
                'safety_standards' => '12V low-voltage LED certified',
                'age_range' => 'All Ages',
                'lead_time' => '2-3 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Sleek Backlit Constellation Board | Lumos Nursery Studio',
                'meta_description' => 'Custom warm LED night sky star ceiling board. Dimmable, safe, sleep-friendly nursery ceiling decor in Colombo.',
                'og_image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['cloud-backlit-motif', 'royal-pastel-round-crib'],
            ],
            [
                'name' => 'Dreamy Cloud Backlit Motif Panel',
                'slug' => 'cloud-backlit-motif',
                'price' => 'LKR 35,000',
                'description' => '<p>Organic shaped wooden cloud board panels mounted with offset LED strips to create a soft, dim, sleep-inducing glow behind the crib.</p><h3>Key Features</h3><ul><li>Floating cloud silhouette design</li><li>Soft indirect ambient glow</li><li>Easy wall-hanging bracket structure</li></ul>',
                'highlights' => [
                    'Soothing floating cloud wall lighting',
                    'Gentle ambient nightlight helper',
                    '100% natural solid wood carving panels',
                    'Non-heating LED bulbs ensure absolute kid protection'
                ],
                'dimensions' => '60 x 40 x 4 cm',
                'material' => 'Eco-certified MDF & warm LED strip',
                'safety_standards' => 'Cool-touch non-heating LEDs',
                'age_range' => 'All Ages',
                'lead_time' => '2 Weeks',
                'show_on_home' => true,
                'status' => 'published',
                'meta_title' => 'Dreamy Cloud Backlit Motif Panel | Lumos Nursery Studio',
                'meta_description' => 'Floating cloud backlit wooden wall panel with soft sleep glow. Perfect bedside night light for kids bedrooms.',
                'og_image' => 'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&w=1200&q=80',
                'image' => 'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&w=800&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1542044896530-05d85be9b11a?auto=format&fit=crop&w=1200&q=80'
                ],
                'related_slugs' => ['backlit-constellation-board', 'royal-pastel-round-crib'],
            ],
        ];

        // Insert products
        foreach ($products as $pData) {
            Product::create([
                'name' => $pData['name'],
                'slug' => $pData['slug'],
                'price' => $pData['price'],
                'description' => $pData['description'],
                'highlights' => $pData['highlights'],
                'dimensions' => $pData['dimensions'],
                'material' => $pData['material'],
                'safety_standards' => $pData['safety_standards'],
                'age_range' => $pData['age_range'],
                'lead_time' => $pData['lead_time'],
                'show_on_home' => $pData['show_on_home'],
                'status' => $pData['status'],
                'meta_title' => $pData['meta_title'],
                'meta_description' => $pData['meta_description'],
                'og_image' => $pData['og_image'],
                'image' => $pData['image'],
                'images' => $pData['images'],
            ]);
        }

        // Establish relationships
        foreach ($products as $pData) {
            $product = Product::where('slug', $pData['slug'])->first();
            if ($product && isset($pData['related_slugs'])) {
                $relatedIds = Product::whereIn('slug', $pData['related_slugs'])->pluck('id')->toArray();
                $product->relatedProducts()->sync($relatedIds);
            }
        }
    }
}
