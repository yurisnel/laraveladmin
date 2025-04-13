<?php

use App\Models\Access\User;
use Illuminate\Support\Facades\Hash;

it('user create screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/users/create');

    $response->assertStatus(200);
});

it('user can be create', function () {
    $user = User::factory()->create();
    $newUser = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'fathername' => fake()->lastName(),
        'mothername' => fake()->lastName(),
        'rut' => "38.247.151-2" //fake()->text(15)
    ];

    $response =  $this->actingAs($user)->post('/users', $newUser);
    //$response->assertSessionHasNoErrors();
    $response->assertStatus(201);
    $this->assertDatabaseHas('users', [
        'name' => $newUser['name'],
        'email' =>  $newUser['email'],
    ]);
});
