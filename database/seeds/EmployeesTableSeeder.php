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

        DB::table('employees')->insert([
            'name' => "Виталий Борисович Беляев",
            'email' => "big@boss.com",
            'password' => bcrypt('123456'),
            'position' => "Генеральный директор",
            'date_of_employment' => "2005-05-24",
            'salary' => 120000,
            'hierarchy_level' => 1,
            'remember_token' => str_random(60),
        ]);

        factory(Employee::class, 999)->create();
    }
}
