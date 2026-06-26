<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminServiceController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Service::query()->latest();

            return DataTables::of($query)
                ->addColumn('action', function ($service) {
                    $editBtn = '<a href="'.route('admin.services.edit', $service->slug).'" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: var(--color-blue); background: transparent;">Edit</a>';

                    $deleteBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmDelete('.$service->id.', \''.addslashes($service->name).'\')">Delete</button>'
                        .'<form id="delete-form-'.$service->id.'" action="'.route('admin.services.delete', $service->slug).'" method="POST" style="display:none;">'
                        .csrf_field()
                        .method_field('DELETE')
                        .'</form>';

                    return '<div class="d-flex">'.$editBtn.$deleteBtn.'</div>';
                })
                ->addColumn('is_featured', function ($service) {
                    $color = $service->is_featured ? '#22c55e' : '#94a3b8';
                    $label = $service->is_featured ? 'Yes' : 'No';

                    return '<span style="color:'.$color.'; font-size: 12px; font-weight: 600;">'.$label.'</span>';
                })
                ->addColumn('status', function ($service) {
                    $isPublished = $service->status === 'published';
                    $color = $isPublished ? '#22c55e' : '#f59e0b';
                    $label = $isPublished ? 'Published' : 'Draft';
                    return '<span class="badge" style="background: rgba('.($isPublished ? '34, 197, 94' : '245, 158, 11').', 0.15); color: '.$color.'; border: 1px solid rgba('.($isPublished ? '34, 197, 94' : '245, 158, 11').', 0.25);">'.$label.'</span>';
                })
                ->addColumn('image', function ($service) {
                    if ($service->image) {
                        return '<img src="'.$service->primaryImageUrl().'" style="height: 40px; width: 40px; object-fit: cover; border-radius: 8px;" />';
                    }

                    return '<span class="text-white-50" style="font-size: 12px;">No Image</span>';
                })
                ->rawColumns(['action', 'image', 'is_featured', 'status'])
                ->make(true);
        }

        return view('backend.services.index', [
            'title' => 'Service Management | Lumos',
        ]);
    }

    public function create(): View
    {
        $allProducts = Product::query()->orderBy('name')->get(['id', 'name']);

        return view('backend.services.create', [
            'title' => 'Create Service | Lumos',
            'allProducts' => $allProducts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'category' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'reviews' => 'nullable|array',
            'reviews.*.name' => 'required|string|max:255',
            'reviews.*.stars' => 'required|integer|min:1|max:5',
            'reviews.*.text' => 'required|string',
        ]);

        $data = $request->except(['image', 'images', 'products', '_token']);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $request->input('sort_order', 0) ?: 0;

        // Strip empty reviews
        $reviews = $request->input('reviews', []);
        $data['reviews'] = array_values(array_filter($reviews, fn ($r) => ! empty($r['name'])));

        // Handle primary image upload
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                $filename = basename($tempPath);
                $newPath = 'services/'.$filename;
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
                        $newPath = 'services/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    }
                }
            }
        }
        $data['images'] = $gallery;

        $service = Service::create($data);

        // Sync associated products
        $service->products()->sync($request->input('products', []));

        return redirect()->route('admin.services')->with('success', 'Service created successfully!');
    }

    public function edit(Service $service): View
    {
        $allProducts = Product::query()->orderBy('name')->get(['id', 'name']);

        return view('backend.services.edit', [
            'service' => $service,
            'title' => 'Edit Service | Lumos',
            'allProducts' => $allProducts,
            'selectedProductIds' => $service->products()->pluck('products.id')->toArray(),
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,'.$service->id,
            'category' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'keep_images' => 'nullable|array',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'reviews' => 'nullable|array',
            'reviews.*.name' => 'required|string|max:255',
            'reviews.*.stars' => 'required|integer|min:1|max:5',
            'reviews.*.text' => 'required|string',
        ]);

        $data = $request->except(['image', 'images', 'keep_images', 'products', '_token', '_method']);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $request->input('sort_order', 0) ?: 0;

        // Strip empty reviews
        $reviews = $request->input('reviews', []);
        $data['reviews'] = array_values(array_filter($reviews, fn ($r) => ! empty($r['name'])));

        // Handle primary image upload
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                // Delete old image if exists
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $filename = basename($tempPath);
                $newPath = 'services/'.$filename;
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
                if ($service->og_image) {
                    Storage::disk('public')->delete($service->og_image);
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
                        $newPath = 'services/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    }
                }
            }
        }
        $data['images'] = $gallery;

        $service->update($data);

        // Sync associated products
        $service->products()->sync($request->input('products', []));

        return redirect()->route('admin.services')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service): RedirectResponse
    {
        // Delete images from storage
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        foreach ($service->images ?? [] as $img) {
            Storage::disk('public')->delete($img);
        }

        $service->delete();

        return redirect()->route('admin.services')->with('success', 'Service deleted successfully!');
    }
}
