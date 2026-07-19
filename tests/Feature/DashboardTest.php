<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
    $user = User::factory()->create();
    $user->assignRole('Admin');
    $this->actingAs($user);

    $response = $this->get(route('admin.dashboard'));
    $response->dump();
    $response->assertOk();
});