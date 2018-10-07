<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            			$table->increments("id");
			$table->integer("parent_id");
			$table->integer("hierarchy_level");
			$table->string("avatar",255)->nullable();
			$table->string("name",255);
			$table->string("email",255)->unique();
			$table->string("password",255);
			$table->string("position",255);
			$table->string("date_of_employment",255);
			$table->string("salary",255);
			$table->string("remember_token",100)->nullable();
			$table->timestamp("created_at")->nullable();
			$table->timestamp("updated_at")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
