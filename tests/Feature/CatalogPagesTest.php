<?php

beforeEach(function () {
    $this->seed();
});

test('services listing page renders successfully with filter buttons and pagination', function () {
    $response = $this->get(route('services.index'));

    $response->assertOk();
    $response->assertSee('Explore Our Luxury Nursery Designs & Organic Products');
    $response->assertSee('Interior Services');
    $response->assertSee('Bespoke Kids Products');
    $response->assertSee('Interior Service');
    $response->assertSee('Organic Product');
    
    // Check that standard pagination link markup is loaded
    $response->assertSee('page-link');
});

test('service detail page renders successfully with related products, reviews, and lightboxed gallery', function () {
    $response = $this->get(route('services.show', 'baby-nursery-design'));

    $response->assertOk();
    $response->assertSee('Baby Nursery Space Design & Styling');
    $response->assertSee('Royal Pastel Round');
    $response->assertSee('Dilani S. (Colombo 07)');
    
    // Check that gallery elements render with modal popup data properties
    $response->assertSee('social-post-card');
    $response->assertSee('data-images');
});

test('product detail page renders successfully and related room styling links', function () {
    $response = $this->get(route('products.show', 'royal-pastel-round-crib'));

    $response->assertOk();
    $response->assertSee('Royal Pastel Round Organic Crib');
    $response->assertSee('Baby Nursery Space Design & Styling');
});

test('newly added services render successfully on detail pages', function () {
    $response1 = $this->get(route('services.show', 'sleep-acoustic-optimization'));
    $response1->assertOk();
    $response1->assertSee('Newborn Sleep & Acoustic Optimization');
    $response1->assertSee('Scientific soundproofing');
    $response1->assertSee('Shanika R.');
    
    // Assert dynamic meta tags from database are set
    $response1->assertSee('content="Newborn Sleep &amp; Acoustic Optimization | Lumos Nursery Studio"', false);
    $response1->assertSee('content="Soundproofing and acoustic optimization for baby nurseries in Sri Lanka. Creating peaceful sleep environments using scientific soundproofing."', false);

    $response2 = $this->get(route('services.show', 'eco-paint-safety-finishes'));
    $response2->assertOk();
    $response2->assertSee('Eco-Friendly Organic Paint & Safety Finishes');
    $response2->assertSee('Zero-VOC, certified non-toxic painting');
    $response2->assertSee('Minuri K.');
    
    // Assert dynamic meta tags from database are set
    $response2->assertSee('content="Eco-Friendly Organic Paint &amp; Safety Finishes | Lumos Nursery Studio"', false);
    $response2->assertSee('content="Zero-VOC painting and certified non-toxic wall coatings for kids rooms in Sri Lanka. Keeping your nursery air clean and safe."', false);
});
