<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\SystemController;

Route::get('/', HomeController::class)->name('front-end.home');
Route::get('/home', HomeController::class)->name('home');

Route::get('/about', function () {
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    return view('frontend.about', [
        'settings' => $settings,
        'title' => $settings['about_meta_title'] ?? 'Our Story - Lumos Nursery Design Studio Sri Lanka',
        'description' => $settings['about_meta_description'] ?? 'Discover the journey of Lumos, Sri Lanka\'s first specialized kids interior sanctuary design house. Led by Eng. Janith Wijesinghe, we construct safe, dream nursery spaces.',
        'keywords' => $settings['about_meta_keywords'] ?? 'about lumos, kids room designers Sri Lanka, non-toxic baby furniture, Janith Wijesinghe, safety certified nursery Sri Lanka',
        'og_image' => !empty($settings['about_og_image']) ? asset('storage/' . $settings['about_og_image']) : null
    ]);
})->name('about');

Route::get('/gallery', function () {
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    $galleryItems = \App\Models\GalleryItem::query()->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->get();
    return view('frontend.gallery', [
        'settings' => $settings,
        'galleryItems' => $galleryItems,
        'title' => $settings['gallery_meta_title'] ?? 'Nursery & Kids Room Gallery - Lumos Studio Sri Lanka',
        'description' => $settings['gallery_meta_description'] ?? 'Browse through our premium collection of luxury nursery designs, custom baby furniture, starry backdrop installations, and completed child-safe room setups.',
        'keywords' => $settings['gallery_meta_keywords'] ?? 'nursery gallery Colombo, baby room portfolio Sri Lanka, custom baby furniture design, kids bedroom projects, Lumos interior portfolio',
        'og_image' => !empty($settings['gallery_og_image']) ? asset('storage/' . $settings['gallery_og_image']) : null
    ]);
})->name('gallery');

use App\Http\Controllers\Frontend\ProductServiceController;

Route::get('/contact', function () {
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    return view('frontend.contact', [
        'settings' => $settings,
        'title' => $settings['contact_meta_title'] ?? 'Contact Us - Lumos Kids Nursery & Kids Room Designers Colombo',
        'description' => $settings['contact_meta_description'] ?? 'Get in touch with Lumos, Sri Lanka\'s leading nursery and child interior design studio. Contact us for bespoke round cribs, organic furniture, and dream child rooms.',
        'keywords' => $settings['contact_meta_keywords'] ?? 'contact lumos, baby nursery designs Colombo, nursery consulting Sri Lanka, child safe room decorators, custom cribs inquiries',
        'og_image' => !empty($settings['contact_og_image']) ? asset('storage/' . $settings['contact_og_image']) : null
    ]);
})->name('contact');

// Static informational pages
Route::view('/privacy-policy', 'frontend.privacy', [
    'title' => 'Privacy Policy - Lumos Nursery Interior Studio',
    'description' => 'Privacy policy for Lumos Nursery Interior Studio',
    'keywords' => 'privacy policy lumos'
])->name('privacy');

Route::view('/safety-guide', 'frontend.safety', [
    'title' => 'Safety Guide - Lumos Nursery Interior Studio',
    'description' => 'Safety guide and best practices for nursery furniture and installations',
    'keywords' => 'safety guide lumos nursery'
])->name('safety');

Route::view('/faq', 'frontend.faq', [
    'title' => 'FAQ - Frequently Asked Questions',
    'description' => 'Frequently asked questions about Lumos services and products',
    'keywords' => 'faq lumos'
])->name('faq');

Route::get('/services', [ProductServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ProductServiceController::class, 'showService'])->name('services.show');
Route::get('/products/{slug}', [ProductServiceController::class, 'showProduct'])->name('products.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/clear', [SystemController::class, 'clear'])->name('system.clear');
Route::get('/storage-create', [SystemController::class, 'storageCreate'])->name('system.storage-create');

if (config('app.debug')) {
    Route::get('/start', [SystemController::class, 'start'])->name('system.start');
}

require __DIR__.'/settings.php';
require __DIR__.'/admin.php';

Route::post('/quotes', [\App\Http\Controllers\Frontend\ProductServiceController::class, 'storeQuote'])->name('quotes.store');
Route::post('/contact', [\App\Http\Controllers\Frontend\ProductServiceController::class, 'storeContact'])->name('contact.store');

