<?php

/** @var Factory $factory */

use App\AttributeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(AttributeValue::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'attribute_group_id' => $faker->numberBetween(1, 20)
    ];
});
