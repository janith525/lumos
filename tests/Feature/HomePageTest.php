<?php

beforeEach(function () {
    $this->seed();
});

test('homepage renders successfully and matches all SEO requirements', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Lumos Nursery & Baby Room Interior Design Studio Sri Lanka');
    $response->assertSee('Pioneer Luxury Nursery Design');
    $response->assertSee('Kids Interior Studio');
    $response->assertSee('Services');
    $response->assertSee('Specialized');
    $response->assertSee('Products');
    $response->assertSee('Ready to Create Your Tiny Dream?');

    // Assert dynamic SEO meta tags are loaded from settings database
    $response->assertSee('content="Lumos Nursery &amp; Baby Room Interior Design Studio Sri Lanka"', false);
    $response->assertSee('content="Lumos is Sri Lanka&#039;s first specialized luxury nursery design and kids interior studio. We create tiny dreams with bespoke cribs and safe spaces."', false);
    $response->assertSee('content="nursery design Sri Lanka, baby room interior Colombo, kids furniture, custom cribs"', false);
});
