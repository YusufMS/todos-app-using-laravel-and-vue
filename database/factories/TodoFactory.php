<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(15),
        'description' => $faker->realText(191),
        'completed' => false,
        'starred' => false,
        'user_id' => 1
    ];
});
