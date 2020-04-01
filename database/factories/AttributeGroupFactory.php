<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AttributeGroup;
use Faker\Generator as Faker;

$factory->define(AttributeGroup::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'type' => $faker->word
    ];
});
