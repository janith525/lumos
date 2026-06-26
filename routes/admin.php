<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminQuotesController;
use App\Http\Controllers\AdminRolesController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'backend.access'])->group(function () {
    // Temporary File Uploads
    Route::post('/admin/uploads/process', [UploadController::class, 'process'])->name('admin.uploads.process');
    Route::delete('/admin/uploads/revert', [UploadController::class, 'revert'])->name('admin.uploads.revert');

    // Dashboard
    Route::get('/admin/dashboard', [AdminStaffController::class, 'dashboard'])->name('admin.dashboard');

    // Staff Management
    Route::get('/admin/staff', [AdminStaffController::class, 'index'])->name('admin.staff');
    Route::get('/admin/staff/export', [AdminStaffController::class, 'export'])->name('admin.staff.export');
    Route::post('/admin/staff', [AdminStaffController::class, 'store'])->name('admin.staff.store');
    Route::put('/admin/staff/{id}', [AdminStaffController::class, 'update'])->name('admin.staff.update');
    Route::delete('/admin/staff/{id}', [AdminStaffController::class, 'destroy'])->name('admin.staff.delete');
    Route::post('/admin/staff/{id}/reset-password', [AdminStaffController::class, 'resetPassword'])->name('admin.staff.reset_password');

    // Roles & Permissions (Super Admin only - enforced via gate/middleware)
    Route::get('/admin/roles', [AdminRolesController::class, 'index'])->name('admin.roles');
    Route::get('/admin/roles/export', [AdminRolesController::class, 'export'])->name('admin.roles.export');
    Route::post('/admin/roles', [AdminRolesController::class, 'store'])->name('admin.roles.store');
    Route::put('/admin/roles/{id}', [AdminRolesController::class, 'update'])->name('admin.roles.update');
    Route::delete('/admin/roles/{id}', [AdminRolesController::class, 'destroy'])->name('admin.roles.delete');

    // Products Management (CRUD)
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.delete');

    // Services Management (CRUD) - Renamed from solutions
    Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services');
    Route::get('/admin/services/create', [AdminServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}/edit', [AdminServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.delete');

    // Quotes Management
    Route::get('/admin/quotes', [AdminQuotesController::class, 'index'])->name('admin.quotes');
    Route::delete('/admin/quotes/{id}', [AdminQuotesController::class, 'destroy'])->name('admin.quotes.delete');

    // Settings Panels
    Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->name('admin.settings');
    Route::get('/admin/settings/home', [AdminSettingsController::class, 'home'])->name('admin.settings.home');
    Route::get('/admin/settings/about', [AdminSettingsController::class, 'about'])->name('admin.settings.about');
    Route::get('/admin/settings/contact', [AdminSettingsController::class, 'contact'])->name('admin.settings.contact');
    Route::get('/admin/settings/navigation', [AdminSettingsController::class, 'navigation'])->name('admin.settings.navigation');
    Route::post('/admin/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
});
