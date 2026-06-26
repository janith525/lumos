<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Products Table (Lumos version with price)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('price')->nullable(); // Enhanced pricing column for Lumos
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Gallery images JSON array
            $table->json('highlights')->nullable(); // Highlights JSON array
            $table->string('dimensions')->nullable();
            $table->string('material')->nullable();
            $table->string('safety_standards')->nullable();
            $table->string('age_range')->nullable();
            $table->string('lead_time')->nullable();
            $table->boolean('show_on_home')->default(false);
            $table->string('status')->default('draft'); // published, draft
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        // 2. Services Table (Renamed from solutions)
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('project_timeline')->nullable();
            $table->string('consultation_fee')->nullable();
            $table->json('inclusions')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('status')->default('draft'); // published, draft
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->json('reviews')->nullable(); // JSON array storing multiple reviews/testimonials
            $table->timestamps();
        });

        // 3. Product & Service Pivot Table (Renamed from product_solution)
        Schema::create('product_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['product_id', 'service_id']);
        });

        // 4. Product Related Products Pivot Table
        Schema::create('product_related_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('related_product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['product_id', 'related_product_id']);
        });

        // 5. Settings Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 6. Home Slides Table
        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->string('kicker')->nullable();
            $table->string('title');
            $table->text('subtext')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 7. Temporary Uploads Table
        Schema::create('temporary_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('folder');
            $table->string('filename');
            $table->string('path');
            $table->unsignedBigInteger('size');
            $table->string('mime_type');
            $table->timestamps();
        });

        // 8. Quotes/Inquiries Table
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->json('products')->nullable(); // Holds selected product IDs if any
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('temporary_uploads');
        Schema::dropIfExists('home_slides');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('product_related_products');
        Schema::dropIfExists('product_service');
        Schema::dropIfExists('services');
        Schema::dropIfExists('products');
    }
};
