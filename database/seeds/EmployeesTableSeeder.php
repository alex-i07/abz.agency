<?php

use App\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

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

        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/users-avatars');

        $percentage = explode(',', env('PERCENTAGE'));

        $parentIdsRange = ['min' => 0, 'max' => 0];

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


                        return $parentId;
                    }
                ]);

            $parentIdsRange['min'] = $parentIdsRange['max'];

            $parentIdsRange['max'] += $value * (int)env('EMPLOYEES_NUMBER');

        }

    }
}