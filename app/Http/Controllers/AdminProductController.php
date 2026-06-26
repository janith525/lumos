<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminProductController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Product::query()->latest();

            return DataTables::of($query)
                ->addColumn('action', function ($product) {
                    $editBtn = '<a href="'.route('admin.products.edit', $product->slug).'" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: var(--color-blue); background: transparent;">Edit</a>';

                    $deleteBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmDelete('.$product->id.', \''.addslashes($product->name).'\')">Delete</button>'
                        .'<form id="delete-form-'.$product->id.'" action="'.route('admin.products.delete', $product->slug).'" method="POST" style="display:none;">'
                        .csrf_field()
                        .method_field('DELETE')
                        .'</form>';

                    return '<div class="d-flex">'.$editBtn.$deleteBtn.'</div>';
                })
                ->addColumn('price', function ($product) {
                    return '<span style="font-size: 13px; font-weight: 600; color: #ffffff;">'.e($product->price ?? 'N/A').'</span>';
                })
                ->addColumn('show_on_home', function ($product) {
                    $color = $product->show_on_home ? '#22c55e' : '#94a3b8';
                    $label = $product->show_on_home ? 'Yes' : 'No';

                    return '<span style="color:'.$color.'; font-size: 12px; font-weight: 600;">'.$label.'</span>';
                })
                ->addColumn('status', function ($product) {
                    $isPublished = $product->status === 'published';
                    $color = $isPublished ? '#22c55e' : '#f59e0b';
                    $label = $isPublished ? 'Published' : 'Draft';
                    return '<span class="badge" style="background: rgba('.($isPublished ? '34, 197, 94' : '245, 158, 11').', 0.15); color: '.$color.'; border: 1px solid rgba('.($isPublished ? '34, 197, 94' : '245, 158, 11').', 0.25);">'.$label.'</span>';
                })
                ->addColumn('image', function ($product) {
                    if ($product->image) {
                        return '<img src="'.$product->primaryImageUrl().'" style="height: 40px; width: 40px; object-fit: cover; border-radius: 8px;" />';
                    }

                    return '<span class="text-white-50" style="font-size: 12px;">No Image</span>';
                })
                ->rawColumns(['action', 'price', 'image', 'show_on_home', 'status'])
                ->make(true);
        }

        return view('backend.products.index', [
            'title' => 'Product Management | Lumos',
        ]);
    }

    public function create(): View
    {
        $allProducts = Product::query()->orderBy('name')->get(['id', 'name', 'slug']);

        return view('backend.products.create', [
            'title' => 'Create Product | Lumos',
            'allProducts' => $allProducts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'nullable|string|max:255', // dynamic pricing
            'status' => 'required|string|in:published,draft',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'show_on_home' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'related_products' => 'nullable|array',
            'related_products.*' => 'exists:products,id',
            'dimensions' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'safety_standards' => 'nullable|string|max:255',
            'age_range' => 'nullable|string|max:255',
            'lead_time' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image', 'images', 'related_products', '_token']);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['show_on_home'] = $request->boolean('show_on_home');

        // Remove empty highlight strings
        $data['highlights'] = array_values(array_filter($request->input('highlights', []), fn ($h) => filled($h)));

        // Handle primary image upload
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                $filename = basename($tempPath);
                $newPath = 'products/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['image'] = $newPath;
                UploadHelper::cleanup($request->input('image'));
            }
        }

        // Handle OG image upload
        if ($request->filled('og_image')) {
            $tempPath = UploadHelper::resolve($request->input('og_image'));
            if ($tempPath) {
                $filename = basename($tempPath);
                $newPath = 'og_images/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['og_image'] = $newPath;
                UploadHelper::cleanup($request->input('og_image'));
            }
        }

        // Handle secondary images gallery
        $gallery = [];
        if ($request->has('images')) {
            foreach ($request->input('images') as $token) {
                if (! empty($token)) {
                    $tempPath = UploadHelper::resolve($token);
                    if ($tempPath) {
                        $filename = basename($tempPath);
                        $newPath = 'products/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    }
                }
            }
        }
        $data['images'] = $gallery;

        $product = Product::create($data);

        // Sync related products
        $product->relatedProducts()->sync($request->input('related_products', []));

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product): View
    {
        $allProducts = Product::query()
            ->whereKeyNot($product->getKey())
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('backend.products.edit', [
            'product' => $product,
            'title' => 'Edit Product | Lumos',
            'allProducts' => $allProducts,
            'selectedRelatedIds' => $product->relatedProducts()->pluck('products.id')->toArray(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'nullable|string',
            'price' => 'nullable|string|max:255', // dynamic pricing
            'status' => 'required|string|in:published,draft',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'show_on_home' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'keep_images' => 'nullable|array',
            'related_products' => 'nullable|array',
            'related_products.*' => 'exists:products,id',
            'dimensions' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'safety_standards' => 'nullable|string|max:255',
            'age_range' => 'nullable|string|max:255',
            'lead_time' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image', 'images', 'keep_images', 'related_products', '_token', '_method']);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['show_on_home'] = $request->boolean('show_on_home');

        // Remove empty highlight strings
        $data['highlights'] = array_values(array_filter($request->input('highlights', []), fn ($h) => filled($h)));

        // Handle primary image upload
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $filename = basename($tempPath);
                $newPath = 'products/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['image'] = $newPath;
                UploadHelper::cleanup($request->input('image'));
            }
        }

        // Handle OG image upload
        if ($request->filled('og_image')) {
            $tempPath = UploadHelper::resolve($request->input('og_image'));
            if ($tempPath) {
                // Delete old OG image if exists
                if ($product->og_image) {
                    Storage::disk('public')->delete($product->og_image);
                }
                $filename = basename($tempPath);
                $newPath = 'og_images/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['og_image'] = $newPath;
                UploadHelper::cleanup($request->input('og_image'));
            }
        }

        // Handle secondary images gallery
        $gallery = $request->input('keep_images', []);
        if ($request->has('images')) {
            foreach ($request->input('images') as $token) {
                if (! empty($token)) {
                    $tempPath = UploadHelper::resolve($token);
                    if ($tempPath) {
                        $filename = basename($tempPath);
                        $newPath = 'products/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    }
                }
            }
        }
        $data['images'] = $gallery;

        $product->update($data);

        // Sync related products
        $product->relatedProducts()->sync($request->input('related_products', []));

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Delete images from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        foreach ($product->images ?? [] as $img) {
            Storage::disk('public')->delete($img);
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
}
