<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Hebergements;

use Faker\Generator as Faker;

$factory->define(Hebergements::class, function (Faker $faker) {
    return [

        'type' => $faker->word,
        'rooms' =>$faker->numberBetween(5, 20) ,
        'ranking' => $faker->numberBetween(1, 5),
        'wifi' => $faker->boolean(50),
        'piscine' => $faker->boolean(50),
        'restaurant' => $faker->boolean(50),
        'spa' => $faker->boolean(50),
        'fitness' => $faker->boolean(50),
        'rooms' => $faker->boolean(50),
    ];
});
