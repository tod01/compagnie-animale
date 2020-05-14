<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Animal;
use Faker\Generator as Faker;

$factory->define(animal::class, function (Faker $faker) {
    return [
        /*$table->integer("age");
        $table->integer("number_of_litters");
        $table->integer("identification_number");
        $table->boolean("is_race");
        $table->boolean("is_vaccinated");
        $table->unsignedBigInteger("race_id");*/

        'age' => $faker->numberBetween($min=0, $max=2),
        'number_of_litters' => $faker->numberBetween($min=1, $max=99),
        'identification_number' => $faker->randomNumber(),
        'is_race' => $faker->numberBetween($min=0, $max=1),
        'is_vaccinated' => $faker->numberBetween($min=0, $max=1),
        'race_id' => $faker->numberBetween($min=1, $max=2),
    ];
});
