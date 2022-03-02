<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->string('employee_name',100);
            $table->string('employee_email',150);
            $table->string('image_path',100);
            $table->unsignedBigInteger('designation_id');
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->foreign('designation_id')->references('designation_id')->on('designations');
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
