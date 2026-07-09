<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactInquiry;
use App\Mail\QuoteRequest;
use App\Models\Product;
use App\Models\Service;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProductServiceController extends Controller
{
    private function mapService(Service $service): array
    {
        return [
            'slug' => $service->slug,
            'type' => 'service',
            'title' => $service->name,
            'tagline' => $service->subtitle,
            'description' => $service->description,
            'image' => $service->resolveImageUrl($service->image),
            'related_products' => $service->products->pluck('slug')->toArray(),
            'reviews' => $service->reviews ?? [],
            'gallery' => $service->galleryImageUrls(),
            'project_timeline' => $service->project_timeline,
            'consultation_fee' => $service->consultation_fee,
            'inclusions' => $service->inclusions ?? [],
        ];
    }

    private function mapProduct(Product $product): array
    {
        return [
            'slug' => $product->slug,
            'type' => 'product',
            'title' => $product->name,
            'price' => $product->price,
            'tagline' => !empty($product->highlights) ? $product->highlights[0] : '',
            'description' => $product->description,
            'image' => $product->resolveImageUrl($product->image),
            'related_services' => $product->services->pluck('slug')->toArray(),
            'gallery' => $product->galleryImageUrls(),
            'dimensions' => $product->dimensions,
            'material' => $product->material,
            'safety_standards' => $product->safety_standards,
            'age_range' => $product->age_range,
            'lead_time' => $product->lead_time,
        ];
    }

    public function index(Request $request)
    {
        $type = $request->query('type', 'all');
        $items = [];

        if ($type === 'services') {
            $services = Service::where('status', 'published')->orderBy('sort_order', 'asc')->get();
            foreach ($services as $service) {
                $items[] = $this->mapService($service);
            }
        } elseif ($type === 'products') {
            $products = Product::where('status', 'published')->orderBy('id', 'desc')->get();
            foreach ($products as $product) {
                $items[] = $this->mapProduct($product);
            }
        } else {
            $services = Service::where('status', 'published')->orderBy('sort_order', 'asc')->get();
            $products = Product::where('status', 'published')->orderBy('id', 'desc')->get();
            
            $mappedServices = $services->map(fn($s) => $this->mapService($s))->toArray();
            $mappedProducts = $products->map(fn($p) => $this->mapProduct($p))->toArray();

            // Interleave services and products beautifully
            $maxCount = max(count($mappedServices), count($mappedProducts));
            for ($i = 0; $i < $maxCount; $i++) {
                if (isset($mappedServices[$i])) {
                    $items[] = $mappedServices[$i];
                }
                if (isset($mappedProducts[$i])) {
                    $items[] = $mappedProducts[$i];
                }
            }
        }

        $itemsCollect = collect($items);
        $perPage = 6;
        $page = (int) $request->query('page', 1);

        $paginatedItems = new LengthAwarePaginator(
            $itemsCollect->forPage($page, $perPage)->values()->all(),
            $itemsCollect->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('frontend.services_listing', [
            'settings' => $settings,
            'title' => 'Products & Styling Services - Lumos Studio Colombo',
            'description' => 'Browse our high-end nursery interior design services, safety consultation plans, bespoke organic round cribs, and child-safe playhouses.',
            'keywords' => 'nursery services, baby furniture Colombo, organic round cribs Sri Lanka, kids design studio catalog',
            'items' => $paginatedItems,
            'currentType' => $type
        ]);
    }

    public function showService(string $slug)
    {
        $serviceModel = Service::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $service = $this->mapService($serviceModel);

        // Map related products by slug
        $relatedProducts = $serviceModel->products->map(fn($p) => $this->mapProduct($p))->toArray();

        return view('frontend.service_detail', [
            'title' => $serviceModel->meta_title ?: ($service['title'] . ' - Lumos Kids Interior Design'),
            'description' => $serviceModel->meta_description ?: ($service['tagline'] . ' Certified child safety standards and bespoke craftsmanship in Colombo.'),
            'keywords' => strtolower($service['title']) . ', nursery designer Sri Lanka, baby room decorator',
            'og_image' => $serviceModel->ogImageUrl(),
            'service' => $service,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function showProduct(string $slug)
    {
        $productModel = Product::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $product = $this->mapProduct($productModel);

        // Map related services by slug
        $relatedServices = $productModel->services->map(fn($s) => $this->mapService($s))->toArray();

        return view('frontend.product_detail', [
            'title' => $productModel->meta_title ?: ($product['title'] . ' - Lumos Bespoke Kids Collection'),
            'description' => $productModel->meta_description ?: ($product['tagline'] . ' Crafted with 100% organic materials and soft-close hardware.'),
            'keywords' => strtolower($product['title']) . ', bespoke round crib Sri Lanka, solid wood baby furniture',
            'og_image' => $productModel->ogImageUrl(),
            'product' => $product,
            'relatedServices' => $relatedServices
        ]);
    }

    /**
     * Handle quote request submissions.
     */
    public function storeQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'message' => 'nullable|string',
            'products' => 'nullable|array', // array of product IDs
            'products.*' => 'exists:products,id',
        ]);

        $quote = Quote::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'] ?? null,
            'products' => $validated['products'] ?? null,
        ]);

        // Send email (using log driver or mailhog)
        try {
            Mail::to(config('mail.from.address', 'hello@lumos.lk'))->send(new QuoteRequest($quote));
        } catch (\Exception $e) {
            // Log warning but continue
            \Illuminate\Support\Facades\Log::warning('Mail failed: ' . $e->getMessage());
        }

        return response()->json(['status' => 'success', 'message' => 'Quote request submitted successfully.']);
    }

    /**
     * Handle contact form submissions.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $formattedMessage = '[Subject: ' . $validated['subject'] . "] \n\n" . $validated['message'];

        $quote = Quote::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $formattedMessage,
            'products' => null,
        ]);

        // Send email notification
        try {
            Mail::to(config('mail.from.address', 'hello@lumos.lk'))->send(new ContactInquiry(
                name: $validated['name'],
                email: $validated['email'],
                phone: $validated['phone'] ?? null,
                subjectText: $validated['subject'],
                messageText: $validated['message']
            ));
        } catch (\Exception $e) {
            // Log warning but continue
            \Illuminate\Support\Facades\Log::warning('Mail failed: ' . $e->getMessage());
        }

        return response()->json(['status' => 'success', 'message' => 'Your message has been sent successfully.']);
    }
}
