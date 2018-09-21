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

////$hierarchyLevel = (function ()
////{
////    /*
////    * Let be 10% of employees of 2nd level(parent_id=1),
////    * 20% of 3rd level(parent_id=2),
////    * 30% of 4th level(parent_id=3)
////    * and 40% of 5 level(parent_id=4)
////     *
////     * @return integer
////    * */
////
////    $weight = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5];
////
////    return $weight[mt_rand(0, 9)];
////
//////    $hierarchyLevel = $faker->numberBetween($min = 2, $max = 5);
////})();
////
/////**
//// *Evaluate parent id for current fake employee
//// *
//// * @return integer
//// */
////
////$parentId = (function () use ($hierarchyLevel) {
//////    dd($hierarchyLevel);
////    $parent = Employee::where('hierarchy_level', '=', $hierarchyLevel - 1 )->inRandomOrder()->first();
////    return $parent->id;
////})();
//var_dump('MARKER');
/** @var \Illuminate\Database\Eloquent\Factory $factory */
//
//$factory->define(App\Employee::class, function (Faker\Generator $faker) use ($hierarchyLevel, $parentId){
//
//    static $password;
//
////    /*
////     * Let be 10% of employees of 2nd level(parent_id=1),
////     * 20% of 3rd level(parent_id=2),
////     * 30% of 4th level(parent_id=3)
////     * and 40% of 5 level(parent_id=4)
////     * */
////
//    $weight = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5];
//
//    $hierarchyLevel = $weight[mt_rand(0, 9)];
////
//////    $hierarchyLevel = $faker->numberBetween($min = 2, $max = 5);
////
//    switch ($hierarchyLevel) {
////        case 1:
////            $salary = $faker->numberBetween($min = 90000, $max = 120000);
////            break;
//        case 2:
//            $salary = $faker->numberBetween($min = 60000, $max = 90000);
//            break;
//        case 3:
//            $salary = $faker->numberBetween($min = 40000, $max = 60000);
//            break;
//        case 4:
//            $salary = $faker->numberBetween($min = 20000, $max = 40000);
//            break;
//        case 5:
//            $salary = $faker->numberBetween($min = 10000, $max = 20000);
//            break;
//    };
//
////    function getRandomUserId() {
////        $user = \App\Employee::where('hierarchy_level', '=', $hierarchyLevel - 1 )->inRandomOrder()->first();
////        return $user->id;
////    }
//
//    /**
//     * Need to select all employees with hierarchyLevel - 1, pick one of them
//     * and write its id as a parent id to current fake employee
//     */
//
////    $ids = Employee::where('hierarchy_level', '=', $hierarchyLevel - 1 )->get()->pluck('id')->toArray();
////
////    $parentId = $ids[mt_rand(0, count($ids)-1)];
////
////    dd($ids, $parentId, $hierarchyLevel);
//
//    return [
//        'parent_id' => 0,
//        'hierarchy_level' => $hierarchyLevel,
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('123456'),
//        'position' => $faker->jobTitle,
//        'date_of_employment' => $faker->date($format = 'Y-m-d', $max = 'now'),
//        'salary' => $salary,
//        'remember_token' => str_random(60),
//    ];
//});


//$factory->define(Employee::class, function (Faker\Generator $faker){
////$factory->define(Employee::class, function (Faker\Generator $faker)
//
//    static $password;
//
////    /*
////     * Let be 10% of employees of 2nd level(parent_id=1),
////     * 20% of 3rd level(parent_id=2),
////     * 30% of 4th level(parent_id=3)
////     * and 40% of 5 level(parent_id=4)
////     * */
//
//    $allEmployeesNumber = env('EMPLOYEES_NUMBER');
//
//    $hierarchyPercentage = explode(',', env('PERCENTAGE'));
//
//    $i = 0; $weights  = []; $levelsNumber = count($hierarchyPercentage);
//    while ($i < $levelsNumber){
//
//        $weights = array_pad($weights, count($weights) + $hierarchyPercentage[$i] * 100, ++$i);
//
//    }
//
//    $hierarchyLevel = $weights[mt_rand(0, count($weights) - 1)];
//
////    $all = Employee::where('hierarchy_level', '=', $hierarchyLevel)->count();
////
////    if ($all === $allEmployeesNumber * $hierarchyPercentage[$hierarchyLevel - 1]) {
////        $hierarchyLevel++;
////    }
////    dd($faker);
////var_dump($all, $allEmployeesNumber * $hierarchyPercentage[$hierarchyLevel - 1], '------', $faker);
////    $weight = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5];
////
////    $hierarchyLevel = $weight[mt_rand(0, 9)];
////
//////    $hierarchyLevel = $faker->numberBetween($min = 2, $max = 5);
////
//    switch ($hierarchyLevel) {
//        case 1:
//            $salary = $faker->numberBetween($min = 90000, $max = 120000);
//            break;
//        case 2:
//            $salary = $faker->numberBetween($min = 60000, $max = 90000);
//            break;
//        case 3:
//            $salary = $faker->numberBetween($min = 40000, $max = 60000);
//            break;
//        case 4:
//            $salary = $faker->numberBetween($min = 20000, $max = 40000);
//            break;
//        case 5:
//            $salary = $faker->numberBetween($min = 10000, $max = 20000);
//            break;
//    };
//
////    if ($hierarchyLevel > 1) {
////        $parentId = Employee::where('hierarchy_level', '=', $hierarchyLevel - 1)->inRandomOrder()->first()->id;
////    }
////    else {
////        $parentId = 0;
////    }
//
////    $tmp = function () {
////        return factory(App\Employerr::class)->create()->id;
////    };
////
////    var_dump($tmp);
////dd(factory(Employee::class)->create()->id);
////    if ($hierarchyLevel > 1) {
////        $parentId = function () {
////            return factory(Employee::class)->parent()->create()->id;
////        };
////    }
////    else {
////        $parentId = 0;
////    }
//
////    var_dump($parentId);
////    exit();
//
//    return [
////        'parent_id' => function ($hierarchyLevel) {
////            if ($hierarchyLevel > 1) {
////                return factory(Employee::class)->parent()->create()->id;
////            }else {
////                return 0;
////            }
////
////        },
//
////        mt_rand(1, 0.1*50000)
//
//        'parent_id' => 1,
//        'hierarchy_level' => $hierarchyLevel,
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('123456'),
//        'position' => $faker->jobTitle,
//        'date_of_employment' => $faker->date($format = 'Y-m-d', $max = 'now'),
//        'salary' => $salary,
//        'remember_token' => str_random(60),
//    ];
//});




$factory->define(Employee::class, function (Faker\Generator $faker){
//$factory->define(Employee::class, function (Faker\Generator $faker)

    static $password;

//    /*
//     * Let be 10% of employees of 2nd level(parent_id=1),
//     * 20% of 3rd level(parent_id=2),
//     * 30% of 4th level(parent_id=3)
//     * and 40% of 5 level(parent_id=4)
//     * */

//    $allEmployeesNumber = env('EMPLOYEES_NUMBER');
//
//    $hierarchyPercentage = explode(',', env('PERCENTAGE'));
//
//    $i = 0; $weights  = []; $levelsNumber = count($hierarchyPercentage);
//    while ($i < $levelsNumber){
//
//        $weights = array_pad($weights, count($weights) + $hierarchyPercentage[$i] * 100, ++$i);
//
//    }
//
//    $hierarchyLevel = $weights[mt_rand(0, count($weights) - 1)];
//
////    $all = Employee::where('hierarchy_level', '=', $hierarchyLevel)->count();
////
////    if ($all === $allEmployeesNumber * $hierarchyPercentage[$hierarchyLevel - 1]) {
////        $hierarchyLevel++;
////    }
////    dd($faker);
////var_dump($all, $allEmployeesNumber * $hierarchyPercentage[$hierarchyLevel - 1], '------', $faker);
////    $weight = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5];
////
////    $hierarchyLevel = $weight[mt_rand(0, 9)];
////
//////    $hierarchyLevel = $faker->numberBetween($min = 2, $max = 5);
////
//
//
////    if ($hierarchyLevel > 1) {
////        $parentId = Employee::where('hierarchy_level', '=', $hierarchyLevel - 1)->inRandomOrder()->first()->id;
////    }
////    else {
////        $parentId = 0;
////    }
//
////    $tmp = function () {
////        return factory(App\Employerr::class)->create()->id;
////    };
////
////    var_dump($tmp);
////dd(factory(Employee::class)->create()->id);
////    if ($hierarchyLevel > 1) {
////        $parentId = function () {
////            return factory(Employee::class)->parent()->create()->id;
////        };
////    }
////    else {
////        $parentId = 0;
////    }
//
////    var_dump($parentId);
////    exit();

    return [
//        'parent_id' => function ($hierarchyLevel) {
//            if ($hierarchyLevel > 1) {
//                return factory(Employee::class)->parent()->create()->id;
//            }else {
//                return 0;
//            }
//
//        },

//        mt_rand(1, 0.1*50000)

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