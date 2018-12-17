<?php

use Faker\Generator as Faker;

$factory->define(Church::class, function (Faker $faker) {
    $denominations = ['Anglican', 'Charismatic', 'Methodist', 'Roman Catholic', 'Presbyterian', 'Baptist'];
    return [
        'uuid' => $faker->Uuid,
        'name' => $faker->company. ' Church',
        'denomination' => $denominations[rand(0,5)],
        'country' => $faker->country
    ];
});
