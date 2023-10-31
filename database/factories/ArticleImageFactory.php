<?php

use Faker\Generator as Faker;

$factory->define(App\ArticleImage::class, function (Faker $faker) {
    return [
        'nombre'=>\Mmo\Faker\PicsumProvider::picsum(storage_path().'/app/public/imagenesArticulos', 400, 400, false),
        'article_id'=>$faker->numberBetween(1,50),
    ];
});
