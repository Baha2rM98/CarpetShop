<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Photo;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'path' => 'https://source.unsplash.com/random',
        'original_name' => $faker->word,
    ];
});
