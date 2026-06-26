<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\HomeSlide;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.settings.index', [
            'settings' => $settings,
            'title' => 'General Settings | Lumos',
        ]);
    }

    public function home(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $slides = HomeSlide::orderBy('sort_order', 'asc')->get();

        return view('backend.settings.home', [
            'settings' => $settings,
            'slides' => $slides,
            'title' => 'Home Page Settings | Lumos',
        ]);
    }

    public function about(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.settings.about', [
            'settings' => $settings,
            'title' => 'About Page Settings | Lumos',
        ]);
    }

    public function contact(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.settings.contact', [
            'settings' => $settings,
            'title' => 'Contact Page Settings | Lumos',
        ]);
    }

    public function navigation(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.settings.navigation', [
            'settings' => $settings,
            'title' => 'Header & Footer Settings | Lumos',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $fileKeys = [
            'logo', 
            'home_about_image', 
            'home_why_choose_image',
            'home_og_image',
            'about_og_image',
            'contact_og_image',
            'contact_qr_image'
        ];
        $inputs = $request->except(array_merge(['_token', 'slides'], $fileKeys));

        // Update settings in database
        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // Handle file uploads dynamically
        foreach ($fileKeys as $fileKey) {
            if ($request->filled($fileKey)) {
                $tempPath = UploadHelper::resolve($request->input($fileKey));
                if ($tempPath) {
                    $oldFile = Setting::where('key', $fileKey)->first()?->value;
                    if ($oldFile) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    $filename = basename($tempPath);
                    $newPath = $fileKey.'/'.$filename;
                    Storage::disk('public')->put($newPath, file_get_contents($tempPath));

                    Setting::updateOrCreate(
                        ['key' => $fileKey],
                        ['value' => $newPath]
                    );

                    UploadHelper::cleanup($request->input($fileKey));
                }
            }
        }

        // Handle dynamic Home slides logic
        if ($request->has('slides')) {
            $slidesJson = $request->input('slides');
            $slidesArray = json_decode($slidesJson, true) ?? [];
            $activeIds = [];

            foreach ($slidesArray as $index => $slideData) {
                $imagePath = $slideData['image'] ?? '';

                // Handle base64 image upload
                if (str_starts_with($imagePath, 'data:image')) {
                    $imageData = substr($imagePath, strpos($imagePath, ',') + 1);
                    $imageData = base64_decode($imageData);
                    $filename = 'hero/'.uniqid().'.jpg';
                    Storage::disk('public')->put($filename, $imageData);
                    $imagePath = Storage::url($filename);
                }

                $slide = HomeSlide::updateOrCreate(
                    ['id' => $slideData['id'] ?? null],
                    [
                        'kicker' => $slideData['kicker'] ?? '',
                        'title' => $slideData['title'] ?? '',
                        'subtext' => $slideData['subtext'] ?? '',
                        'image' => $imagePath,
                        'button_text' => $slideData['button_text'] ?? null,
                        'button_link' => $slideData['button_link'] ?? null,
                        'sort_order' => $index,
                    ]
                );

                $activeIds[] = $slide->id;
            }

            // Clean up deleted slides
            HomeSlide::whereNotIn('id', $activeIds)->delete();
        }

        // Clear configuration & view caches
        Artisan::call('optimize:clear');

        return redirect()->back()->with('success', 'Configuration updated successfully!');
    }
}
