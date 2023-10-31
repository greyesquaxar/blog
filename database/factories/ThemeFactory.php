<?php

use Faker\Generator as Faker;

$factory->define(App\Theme::class, function (Faker $faker) {
    $nombre=$faker->unique()->word;
    return [
        'user_id' => 1, // hacer para que solo un usuario
        'nombre' => ucfirst($nombre),
        'slug' => $nombre,
        'destacado' => $faker->boolean(false),
        'suscripcion' => $faker->boolean(false),
    ];
});
