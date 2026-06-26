<?php

test('homepage renders successfully and matches all SEO requirements', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Lumos Nursery & Baby Room Interior Design Studio Sri Lanka');
    $response->assertSee('Pioneer Luxury Nursery Design');
    $response->assertSee('Kids Interior Studio');
    $response->assertSee('Services');
    $response->assertSee('Specialized Products');
    $response->assertSee('Ready to Create Your Tiny Dream?');
});
