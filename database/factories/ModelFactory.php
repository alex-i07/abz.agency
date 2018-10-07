<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Employee;

$factory->define(Employee::class, function (Faker\Generator $faker){

    static $password;

    return [
        'parent_id' => 0,
        'hierarchy_level' => 0,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'position' => $faker->jobTitle,
        'date_of_employment' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'salary' => 0,
        'remember_token' => str_random(60),
    ];
});