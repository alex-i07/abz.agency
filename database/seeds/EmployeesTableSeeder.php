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

        Employee::truncate();

        $percentage = explode(',', env('PERCENTAGE'));

        $parentIdsRange = ['min' => 0, 'max' => 0];

//        $initialId = 1;

        foreach($percentage as $key => $value) {
             $hierarchyLevel = $key + 1;

            factory(Employee::class, $value * (int)env('EMPLOYEES_NUMBER'))
                ->create([
                    'hierarchy_level' => $hierarchyLevel,
                    'salary' => function() use($hierarchyLevel){

                        if ($hierarchyLevel == 1){
                            return mt_rand(90000, 120000);
                        }
                        elseif ($hierarchyLevel == 2){
                            return mt_rand(60000, 90000);
                        }
                        elseif ($hierarchyLevel == 3){
                            return mt_rand(40000, 60000);
                        }
                        elseif ($hierarchyLevel == 4){
                            return mt_rand(20000, 40000);
                        }
                        elseif ($hierarchyLevel == 5){
                            return mt_rand(10000, 20000);
                        }
                    },
                    'parent_id' => function() use($hierarchyLevel, $value, $parentIdsRange){

                        $hierarchyLevel === 1 ? $parentId = 0: $parentId = mt_rand($parentIdsRange['min'] +1, $parentIdsRange['max']);

//                        if ($hierarchyLevel === 1){
//                            $parentId = 0;
//
//                            $parentIdsRange['max'] = (int)($value * (int)env('EMPLOYEES_NUMBER'));
//
//                        }
//                        else {
////                            $parentId = mt_rand($initialId, $initialId + $previousValue);  //$value уже уровня 2, а не 1!
//                            dd($hierarchyLevel, $parentIdsRange);
//                            $parentId = mt_rand($parentIdsRange['min'] +1, $parentIdsRange['max']);
////                            var_dump($initialId);
//
////                            $parentIdsRange['min'] += $parentIdsRange['max'];
////
////                            $parentIdsRange['max'] = $parentIdsRange['max'] + $value * (int)env('EMPLOYEES_NUMBER');
//
////                            $initialId += $previousValue;
////                            var_dump($initialId, '---------');
//                        }

//                        var_dump('STOP!', $hierarchyLevel, $parentIdsRange);

                        return $parentId;
                    }
                ]);

            $parentIdsRange['min'] = $parentIdsRange['max'];

            $parentIdsRange['max'] += $value * (int)env('EMPLOYEES_NUMBER');

//            $previousValue = $value * (int)env('EMPLOYEES_NUMBER');
        }

    }
}