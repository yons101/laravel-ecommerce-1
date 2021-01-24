<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;

use Illuminate\Support\Arr;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $title = Arr::random(['iphone', 'ipad', 'macbook']);
    return [
        'title' => $title,
        'slug' => "$title-" . $faker->randomNumber(4),
        'description' => $faker->text(500),
        'image' => "/img/" . $title . ".png"
    ];
});
