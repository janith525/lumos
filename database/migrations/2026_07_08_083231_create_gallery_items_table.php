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
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('category'); // e.g. nursery, furniture, playroom, backdrop
            $table->string('image'); // primary thumbnail image path/url
            $table->json('images')->nullable(); // extra slider images JSON array
            $table->string('review_author')->nullable();
            $table->text('review_content')->nullable();
            $table->integer('stars')->default(0);
            $table->string('type')->default('review'); // review or social
            $table->boolean('show_on_home')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
