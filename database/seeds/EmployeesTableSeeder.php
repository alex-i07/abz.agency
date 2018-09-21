<?php

use App\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * There must be only one employee of level 1
     * so I insert him manually
     *
     * @return void
     */
    public function run()
    {

//        DB::table('employees')->insert([
//            'parent_id' => 0,
//            'hierarchy_level' => 1,
//            'name' => "Виталий Борисович Беляев",
//            'email' => "big@boss.com",
//            'password' => bcrypt('123456'),
//            'position' => "Генеральный директор",
//            'date_of_employment' => "2005-05-24",
//            'salary' => 120000,
//            'remember_token' => str_random(60),
//        ]);

//        $employeesNumber = env('EMPLOYEES_NUMBER');

//        factory(Employee::class, (int)env('EMPLOYEES_NUMBER'))->create([
//            'parent_id' => 2
//        ]); //['parent_id' => $this->getRandomBossId()]

        $percentage = explode(',', env('PERCENTAGE'));

        $initialId = 1;

        foreach($percentage as $key => $value) {
//            var_dump($key, $value);
             $hierarchyLevel = ++$key;

//            switch ($hierarchyLevel) {
//                case 1:
//                    $salary = mt_rand(90000, 120000);
//                    break;
//                case 2:
//                    $salary = mt_rand(60000, 90000);
//                    break;
//                case 3:
//                    $salary = mt_rand(40000, 60000);
//                    break;
//                case 4:
//                    $salary = mt_rand(20000, 40000);
//                    break;
//                case 5:
//                    $salary = mt_rand(10000, 20000);
//                    break;
//            };

//            if ($hierarchyLevel === 1){
//                $parent_id = 0;
//            }
//            else {
//                $parent_id = mt_rand($initialId, $initialId + $value * (int)env('EMPLOYEES_NUMBER'));
//
//                var_dump($initialId);
//                $initialId += $value * (int)env('EMPLOYEES_NUMBER');
//                var_dump($initialId, '---------');
//            }

            factory(Employee::class, $value * (int)env('EMPLOYEES_NUMBER'))
                ->create([
                    'hierarchy_level' => $hierarchyLevel,
                    'salary' => function ($hierarchyLevel){

                        if ($hierarchyLevel == 1){
                            $salary = mt_rand(90000, 120000);
                        }
                        elseif ($hierarchyLevel == 2){
                            $salary = mt_rand(60000, 90000);
                        }
                        elseif ($hierarchyLevel == 3){
                            $salary = mt_rand(40000, 60000);
                        }
                        elseif ($hierarchyLevel == 4){
                            $salary = mt_rand(20000, 40000);
                        }
                        elseif ($hierarchyLevel == 5){
                            $salary = mt_rand(10000, 20000);
                        }
dd($hierarchyLevel);
                        return $salary;
//                        switch ($hierarchyLevel) {
//                            case 1:
//                                $salary = mt_rand(90000, 120000);
////                                break;
//                                return $salary;
//                            case 2:
//                                $salary = mt_rand(60000, 90000);
////                                break;
//                                return $salary;
//                            case 3:
//                                $salary = mt_rand(40000, 60000);
////                                break;
//                                return $salary;
//                            case 4:
//                                $salary = mt_rand(20000, 40000);
////                                break;
//                                return $salary;
//                            case 5:
//                                $salary = mt_rand(10000, 20000);
////                                break;
//                                return $salary;
//                        };


                    },                      //salary and parent_id are the same for all level, put mt_rand inside create
                    'parent_id' => function ($hierarchyLevel) use ($initialId, $value){

                        if ($hierarchyLevel === 1){
                            $parentId = 0;
                        }
                        else {
                            $parentId = mt_rand($initialId, $initialId + $value * (int)env('EMPLOYEES_NUMBER'));

                            var_dump($initialId);

                            $initialId += $value * (int)env('EMPLOYEES_NUMBER');
                            var_dump($initialId, '---------');
                        }

                        return $parentId;
                    }
                ]);


//                ->each(function ($u) {
////                $hierarchy_level = $u->hierarchy_level;
//
////                var_dump($u->hierarchy_level, $u->parent_id, $u->parent(), '-----------');
//
//                    $u->hierarchy_level = $hierarchyLevel;
//
//                    $u->parent_id = mt_rand($initialId, $value * (int)env('EMPLOYEES_NUMBER'));
//
//                    $u->save();
//

//
//                });

        }




//        factory(Employee::class, (int)env('EMPLOYEES_NUMBER'))
//            ->create()
//            ->each(function ($u) {
////                $hierarchy_level = $u->hierarchy_level;
//
////                var_dump($u->hierarchy_level, $u->parent_id, $u->parent(), '-----------');
//
//                var_dump($u->id);
//                if ($u->hierarchy_level == 1) {
//                    $u->parent_id = 0;
//                }
//                else {
////                    dd($u->parent()->get());
//                    $collection = Employee::where('hierarchy_level', '=', $u->hierarchy_level - 1)->inRandomOrder()->first();
//
//
////                    dd($collection);
//
////                    if ($collection->isNotEmpty()) {
//                        $id = $collection->id;
////                    }
////                   var_dump($id);
//
//                    $u->parent_id = $id;
//                }
////                $u->parent_id=9;
//                $u->save();
////                $u->children()->save(factory(Employee::class)->make());
////                $u->parent_id = $hierarchy_level;
//            });
//
//    }
//
////    public function getParentId()
////    {
//////        $user = \App\Employee::inRandomOrder()->first();
//////        return $user->id;
////
////        var_dump($hierarchyLevel);
////        return 0;
    }
}