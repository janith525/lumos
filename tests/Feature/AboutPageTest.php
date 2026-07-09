<?php

beforeEach(function () {
    $this->seed();
});

test('about page renders successfully', function () {
    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSee('Our Story');
    $response->assertSee('Dream Rooms Built');
    $response->assertSee('Eng. Janith Wijesinghe');
    $response->assertSee('Our Vision');
    $response->assertSee('Our Mission');

    // Verify dynamic meta settings are loaded and rendered
    $response->assertSee('content="Our Story - Lumos Nursery Design Studio Sri Lanka"', false);
    $response->assertSee('content="Discover the journey of Lumos, Sri Lanka&#039;s first specialized kids interior sanctuary design house. Led by Eng. Janith Wijesinghe, we construct safe, dream nursery spaces."', false);
    $response->assertSee('content="about lumos, kids room designers Sri Lanka, non-toxic baby furniture, Janith Wijesinghe, safety certified nursery Sri Lanka"', false);

    // Verify dynamic story image URLs are rendered
    $response->assertSee('photo-1596704017254-9b121068fb31');
    $response->assertSee('photo-1505691723518-36a5ac3be353');
    $response->assertSee('photo-1540932239986-30128078f3c5');
    $response->assertSee('photo-1560250097-0b93528c311a');
});
