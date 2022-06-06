<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('section_id');
            $table->string('drop_status')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('student_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('age');
            $table->string('gender');
            $table->string('contact_number');
            $table->string('email');
            $table->timestamps();
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
