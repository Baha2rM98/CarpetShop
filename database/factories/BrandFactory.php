<?php

/** @var Factory $factory */

use App\Brand;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->word,
        'description' => $faker->text,
        'photo_id' => $faker->numberBetween(1, 20)
    ];
});
