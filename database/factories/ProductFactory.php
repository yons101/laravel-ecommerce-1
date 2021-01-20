<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Faker\Generator as Faker;


$factory->define(Product::class, function (Faker $faker) {


    $title = Arr::random(['iphone-x', 'iphone-xs', 'iphone-11',  'ipad-air', 'ipad-pro', 'macbook-pro', 'macbook-air']);

    return [
        'title' => $title,
        'slug' => "$title-" . $faker->randomNumber(4),
        'price' => $faker->numberBetween(30, 100) * 100,
        'description' => $faker->text(500),
        'image' => "/img/" . $title . ".png"
    ];
});
