<?php

test('contact page renders successfully and matches all SEO requirements', function () {
    $response = $this->get(route('contact'));

    $response->assertOk();
    $response->assertSee('Contact Us - Lumos Kids Nursery & Kids Room Designers Colombo');
    $response->assertSee('Elite Kids Room');
    $response->assertSee('Nursery Designers');
    $response->assertSee('Visit Our Design Studio');
    $response->assertSee('Quick Contact');
    $response->assertSee('Studio Hours');
    $response->assertSee('Request a Design Consultation');
});
