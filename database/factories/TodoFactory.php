<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'todo_item' => $faker->realText(120),
        'completed' => false,
        'starred' => false,
        'user_id' => 1
    ];
});
