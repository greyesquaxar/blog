<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'titulo' => $faker->sentence(5,true),
		'contenido' => $faker->text(300),
		'activo' => $faker->boolean(true),
		'theme_id' => $faker->numberBetween(1,5),
		'user_id' => $faker->numberBetween(1,10),
    ];
});
