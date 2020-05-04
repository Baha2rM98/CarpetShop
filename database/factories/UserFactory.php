<?php

/** @var Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'national_code' => $faker->postcode,
        'password' => '$argon2id$v=19$m=1024,t=2,p=2$ZE5LSVBRcFRYdWJOQ0wwNg$AJlnH520hhpBfZm7df8Zk9fwI+TiRtfgbvaodqBeV6k', // password
    ];
});
