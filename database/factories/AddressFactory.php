<?php

/** @var Factory $factory */

use App\Address;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'post_code' => $faker->postcode,
        'province_id' => $faker->numberBetween(1, 31),
        'city_id' => $faker->numberBetween(1, 440),
        'user_id' => $faker->unique()->numberBetween(1, 50),
        'primary' => 1
    ];
});
