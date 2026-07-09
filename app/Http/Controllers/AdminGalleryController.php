<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\GalleryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminGalleryController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = GalleryItem::query()->orderBy('sort_order', 'asc')->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $editBtn = '<button type="button" onclick="editItem('.$item->id.')" class="btn btn-outline-primary btn-sm px-3 py-1.5 me-2" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(59,130,246,0.3); color: var(--color-blue); background: transparent;">Edit</button>';

                    $deleteBtn = '<button type="button" class="btn btn-outline-danger btn-sm px-3 py-1.5" style="border-radius: 8px; font-size: 12px; border: 1px solid rgba(231,76,60,0.3); color: #e74c3c; background: transparent;" onclick="confirmDelete('.$item->id.', \''.addslashes($item->title).'\')">Delete</button>'
                        .'<form id="delete-form-'.$item->id.'" action="'.route('admin.gallery.delete', $item->id).'" method="POST" style="display:none;">'
                        .csrf_field()
                        .method_field('DELETE')
                        .'</form>';

                    return '<div class="d-flex">'.$editBtn.$deleteBtn.'</div>';
                })
                ->addColumn('show_on_home', function ($item) {
                    $color = $item->show_on_home ? '#22c55e' : '#94a3b8';
                    $label = $item->show_on_home ? 'Yes' : 'No';

                    return '<span style="color:'.$color.'; font-size: 12px; font-weight: 600;">'.$label.'</span>';
                })
                ->addColumn('category', function ($item) {
                    return ucfirst($item->category);
                })
                ->addColumn('image', function ($item) {
                    if ($item->image) {
                        return '<img src="'.$item->primaryImageUrl().'" style="height: 40px; width: 40px; object-fit: cover; border-radius: 8px;" />';
                    }

                    return '<span class="text-white-50" style="font-size: 12px;">No Image</span>';
                })
                ->rawColumns(['action', 'image', 'show_on_home'])
                ->make(true);
        }

        return view('backend.gallery.index', [
            'title' => 'Gallery Showcase Management | Lumos',
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.gallery');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string|in:nursery,furniture,playroom,backdrop',
            'type' => 'required|string|in:review,social',
            'review_author' => 'nullable|string|max:255',
            'review_content' => 'nullable|string',
            'stars' => 'nullable|integer|min:0|max:5',
            'show_on_home' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'images', '_token']);
        $data['show_on_home'] = $request->boolean('show_on_home');
        $data['sort_order'] = $request->input('sort_order', 0) ?: 0;
        $data['stars'] = $request->input('stars', 0) ?: 0;

        // Handle primary image upload
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                $filename = basename($tempPath);
                $newPath = 'gallery/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['image'] = $newPath;
                UploadHelper::cleanup($request->input('image'));
            }
        }

        // Handle slider images
        $gallery = [];
        if ($request->has('images')) {
            foreach ($request->input('images') as $token) {
                if (! empty($token)) {
                    $tempPath = UploadHelper::resolve($token);
                    if ($tempPath) {
                        $filename = basename($tempPath);
                        $newPath = 'gallery/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    } else {
                        // If token is already a path (not a temp upload)
                        $gallery[] = $token;
                    }
                }
            }
        }
        $data['images'] = $gallery;

        GalleryItem::create($data);

        return redirect()->route('admin.gallery')->with('success', 'Gallery item created successfully.');
    }

    public function edit(GalleryItem $galleryItem, Request $request): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            $galleryItem->primary_image_url = $galleryItem->primaryImageUrl();
            $galleryItem->gallery_image_urls = $galleryItem->galleryImageUrls();
            return response()->json([
                'success' => true,
                'data' => $galleryItem
            ]);
        }

        return redirect()->route('admin.gallery');
    }

    public function update(Request $request, GalleryItem $galleryItem): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string|in:nursery,furniture,playroom,backdrop',
            'type' => 'required|string|in:review,social',
            'review_author' => 'nullable|string|max:255',
            'review_content' => 'nullable|string',
            'stars' => 'nullable|integer|min:0|max:5',
            'show_on_home' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
        ]);

        $data = $request->except(['image', 'images', '_token']);
        $data['show_on_home'] = $request->boolean('show_on_home');
        $data['sort_order'] = $request->input('sort_order', 0) ?: 0;
        $data['stars'] = $request->input('stars', 0) ?: 0;

        // Primary Image update
        if ($request->filled('image')) {
            $tempPath = UploadHelper::resolve($request->input('image'));
            if ($tempPath) {
                // Delete old image
                if ($galleryItem->image) {
                    Storage::disk('public')->delete($galleryItem->image);
                }

                $filename = basename($tempPath);
                $newPath = 'gallery/'.$filename;
                Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                $data['image'] = $newPath;
                UploadHelper::cleanup($request->input('image'));
            }
        }

        // Secondary images updates
        $gallery = $request->input('keep_images', []);
        if ($request->has('images')) {
            foreach ($request->input('images') as $token) {
                if (! empty($token)) {
                    $tempPath = UploadHelper::resolve($token);
                    if ($tempPath) {
                        $filename = basename($tempPath);
                        $newPath = 'gallery/'.$filename;
                        Storage::disk('public')->put($newPath, file_get_contents($tempPath));
                        $gallery[] = $newPath;
                        UploadHelper::cleanup($token);
                    }
                }
            }
        }

        // Delete removed images
        $removedImages = array_diff($galleryItem->images ?? [], $gallery);
        foreach ($removedImages as $removedImage) {
            Storage::disk('public')->delete($removedImage);
        }
        $data['images'] = $gallery;

        $galleryItem->update($data);

        return redirect()->route('admin.gallery')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(GalleryItem $galleryItem): RedirectResponse
    {
        // Delete primary image
        if ($galleryItem->image) {
            Storage::disk('public')->delete($galleryItem->image);
        }

        // Delete slider images
        foreach ($galleryItem->images ?? [] as $img) {
            Storage::disk('public')->delete($img);
        }

        $galleryItem->delete();

        return redirect()->route('admin.gallery')->with('success', 'Gallery item deleted successfully.');
    }
}
