<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => 'example@example.com',
        'phone_number' => '09197234460',
        'password' => '$argon2id$v=19$m=1024,t=2,p=2$ZE5LSVBRcFRYdWJOQ0wwNg$AJlnH520hhpBfZm7df8Zk9fwI+TiRtfgbvaodqBeV6k', // password
        'super_admin' => 1,
    ];
});
