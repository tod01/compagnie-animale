<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
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

/* https://github.com/fzaninotto/Faker */
$factory->define(user::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'last_name'  => $faker->lastName,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'type_of_user' => 0,
        'department' => $faker->city,
    ];
});
