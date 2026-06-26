<?php

test('about page renders successfully', function () {
    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSee('Pioneer Luxury Nursery');
    $response->assertSee('Kids Room Designers');
    $response->assertSee('How It All Began');
    $response->assertSee('Dream Rooms Built');
    $response->assertSee('Eng. Janith Wijesinghe');
    $response->assertSee('Our Vision');
    $response->assertSee('Our Mission');
});
