<?php

beforeEach(function () {
    $this->seed();
});

test('gallery page renders successfully and matches all SEO requirements', function () {
    $response = $this->get(route('gallery'));

    $response->assertOk();
    $response->assertSee('Nursery & Kids Room Gallery - Lumos Studio Sri Lanka');
    $response->assertSee('Luxury Nursery');
    $response->assertSee('Baby Room Portfolio');
    $response->assertSee('Show All');
    $response->assertSee('Baby Nurseries');
    $response->assertSee('Bespoke Furniture');
    $response->assertSee('Kids Playrooms');
    $response->assertSee('Backdrops');
    $response->assertSee('Decor');
    $response->assertSee('Ready to Create Your Tiny Dream?');
});
