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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Employee::class, function (Faker\Generator $faker) {

    static $password;

    /*
     * Let be 10% of employees of 2nd level,
     * 20% of 3rd level,
     * 30% of 4th level
     * and 40% of 5 level
     * */

    $weight = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5];

    $hierarchyLevel = $weight[mt_rand(0, 9)];

//    $hierarchyLevel = $faker->numberBetween($min = 2, $max = 5);

    switch ($hierarchyLevel) {
//        case 1:
//            $salary = $faker->numberBetween($min = 90000, $max = 120000);
//            break;
        case 2:
            $salary = $faker->numberBetween($min = 60000, $max = 90000);
            break;
        case 3:
            $salary = $faker->numberBetween($min = 40000, $max = 60000);
            break;
        case 4:
            $salary = $faker->numberBetween($min = 20000, $max = 40000);
            break;
        case 5:
            $salary = $faker->numberBetween($min = 10000, $max = 20000);
            break;
    }

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123456'),
        'position' => $faker->jobTitle,
        'date_of_employment' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'salary' => $salary,
        'hierarchy_level' => $hierarchyLevel,
        'remember_token' => str_random(60),
    ];
});
