<?php

/** @var Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'sku' => $faker->postcode,
        'slug' => $faker->unique()->slug,
        'status' => $faker->numberBetween(0, 1),
        'price' => $faker->randomDigit,
        'discount_price' => $faker->randomDigit,
        'description' => $faker->text,
        'brand_id' => $faker->numberBetween(1, 20),
    ];
});
