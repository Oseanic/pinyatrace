<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CovidCase;
use Faker\Generator as Faker;

$factory->define(CovidCase::class, function (Faker $faker) {
    return [
        'patient_id' => $faker->unique()->numberBetween($min = 1, $max = 99),
        'name' => $faker->name,
        'address' => 'Kanluran',
        'email' => $faker->safeEmail,
        'number' => $faker->phoneNumber,
        'status' => 'Recovered'
    ];
});
    