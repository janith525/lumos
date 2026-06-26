<?php

test('services listing page renders successfully with filter buttons and pagination', function () {
    $response = $this->get(route('services.index'));

    $response->assertOk();
    $response->assertSee('Explore Our Luxury Nursery Designs & Organic Products');
    $response->assertSee('Interior Styling Services');
    $response->assertSee('Bespoke Kids Furniture');
    $response->assertSee('Interior Service');
    $response->assertSee('Organic Product');
    
    // Check that standard pagination link markup is loaded
    $response->assertSee('page-link');
});

test('service detail page renders successfully with related products, reviews, and lightboxed gallery', function () {
    $response = $this->get(route('services.show', 'baby-nursery-design'));

    $response->assertOk();
    $response->assertSee('Baby Nursery Space Design & Styling');
    $response->assertSee('Royal Pastel Round Crib');
    $response->assertSee('Dilani S. (Colombo 07)');
    
    // Check that gallery elements render with modal popup data properties
    $response->assertSee('social-post-card');
    $response->assertSee('data-images');
});

test('product detail page renders successfully with price tags and related room styling links', function () {
    $response = $this->get(route('products.show', 'royal-pastel-round-crib'));

    $response->assertOk();
    $response->assertSee('Royal Pastel Round Organic Crib');
    $response->assertSee('LKR 125,000');
    $response->assertSee('Baby Nursery Space Design & Styling');
});
