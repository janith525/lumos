<?php

use App\Models\User;
use App\Models\GalleryItem;
use App\Models\TemporaryUpload;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed();
    Storage::fake('public');
});

test('guest cannot access admin gallery panel', function () {
    $response = $this->get(route('admin.gallery'));
    $response->assertRedirect(route('login'));
});

test('admin can view gallery items list', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $response = $this->actingAs($user)->get(route('admin.gallery'));
    $response->assertOk();
    $response->assertSee('Gallery Showcase Management');
});

test('admin can view gallery create form', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $response = $this->actingAs($user)->get(route('admin.gallery.create'));
    $response->assertRedirect(route('admin.gallery'));
});

test('admin can store new gallery item', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    // Set up fake temporary upload file
    Storage::disk('public')->put('tmp/123/image.jpg', 'fake image data');
    TemporaryUpload::create([
        'token' => 'temp_token_123',
        'folder' => 'tmp/123',
        'filename' => 'image.jpg',
        'path' => 'tmp/123/image.jpg',
        'size' => 1000,
        'mime_type' => 'image/jpeg'
    ]);

    $response = $this->actingAs($user)->post(route('admin.gallery.store'), [
        'title' => 'Starlight Nursery Room',
        'subtitle' => 'Completed Project | Colombo',
        'category' => 'nursery',
        'type' => 'review',
        'review_author' => 'Janith Wijesinghe',
        'review_content' => 'Fabulous design and safe furniture.',
        'stars' => 5,
        'image' => 'temp_token_123',
        'show_on_home' => 1,
        'sort_order' => 10,
    ]);

    $response->assertRedirect(route('admin.gallery'));
    
    $this->assertDatabaseHas('gallery_items', [
        'title' => 'Starlight Nursery Room',
        'category' => 'nursery',
        'review_author' => 'Janith Wijesinghe',
        'stars' => 5,
        'show_on_home' => true,
        'sort_order' => 10,
    ]);

    $item = GalleryItem::where('title', 'Starlight Nursery Room')->first();
    Storage::disk('public')->assertExists($item->image);
});

test('admin can update gallery item', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $item = GalleryItem::create([
        'title' => 'Old Room Title',
        'subtitle' => 'Old Sub',
        'category' => 'furniture',
        'type' => 'social',
        'image' => 'gallery/old_image.jpg',
        'sort_order' => 2,
    ]);

    // Update fields without changing image
    $response = $this->actingAs($user)->put(route('admin.gallery.update', $item->id), [
        'title' => 'New Room Title',
        'subtitle' => 'New Sub',
        'category' => 'playroom',
        'type' => 'social',
        'sort_order' => 5,
    ]);

    $response->assertRedirect(route('admin.gallery'));

    $this->assertDatabaseHas('gallery_items', [
        'id' => $item->id,
        'title' => 'New Room Title',
        'category' => 'playroom',
        'sort_order' => 5,
    ]);
});

test('admin can delete gallery item', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $item = GalleryItem::create([
        'title' => 'To Be Deleted',
        'subtitle' => 'Subtitle',
        'category' => 'backdrop',
        'type' => 'social',
        'image' => 'gallery/delete_me.jpg',
    ]);

    $response = $this->actingAs($user)->delete(route('admin.gallery.delete', $item->id));
    $response->assertRedirect(route('admin.gallery'));

    $this->assertDatabaseMissing('gallery_items', [
        'id' => $item->id,
    ]);
});

test('homepage settings syncs gallery show_on_home state correctly', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $item1 = GalleryItem::create([
        'title' => 'Item 1',
        'category' => 'nursery',
        'type' => 'social',
        'image' => 'gallery/item1.jpg',
        'show_on_home' => false,
    ]);

    $item2 = GalleryItem::create([
        'title' => 'Item 2',
        'category' => 'nursery',
        'type' => 'social',
        'image' => 'gallery/item2.jpg',
        'show_on_home' => true,
    ]);

    $response = $this->actingAs($user)->post(route('admin.settings.update'), [
        'homepage_gallery' => [$item1->id], // Enable item1, disable item2
    ]);

    $response->assertRedirect();
    
    expect($item1->fresh()->show_on_home)->toBeTrue();
    expect($item2->fresh()->show_on_home)->toBeFalse();
});

test('admin can fetch gallery item details as json', function () {
    $user = User::factory()->create();
    $user->assignRole('Admin');
    
    $item = GalleryItem::create([
        'title' => 'Test Room Details',
        'subtitle' => 'Sub Label',
        'category' => 'nursery',
        'type' => 'social',
        'image' => 'gallery/test.jpg',
    ]);

    $response = $this->actingAs($user)->get(route('admin.gallery.edit', $item->id), [
        'HTTP_X-Requested-With' => 'XMLHttpRequest'
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
        'data' => [
            'title' => 'Test Room Details',
            'category' => 'nursery',
        ]
    ]);
});
