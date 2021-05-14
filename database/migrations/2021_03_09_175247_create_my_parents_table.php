<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_parents', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');

            //Father information
            $table->string('father_name');
            $table->string('father_national_id');
            $table->string('father_passport_id');
            $table->string('father_phone');
            $table->string('father_job');
            $table->string('father_address');
            $table->unsignedBigInteger('nationality_father_id');
            $table->unsignedBigInteger('blood_type_father');
            $table->unsignedBigInteger('religion_father');
            $table->foreign('nationality_father_id')->references('id')->on('nationalities')->onUpdate('cascade');
            $table->foreign('blood_type_father')->references('id')->on('bloods')->onUpdate('cascade');
            $table->foreign('religion_father')->references('id')->on('religions')->onUpdate('cascade');

            //Mother information
            $table->string('mother_name');
            $table->string('mother_national_id');
            $table->string('mother_passport_id');
            $table->string('mother_phone');
            $table->string('mother_job');
            $table->string('mother_address');
            $table->unsignedBigInteger('nationality_mother_id');
            $table->unsignedBigInteger('blood_type_mother');
            $table->unsignedBigInteger('religion_mother');
            $table->foreign('nationality_mother_id')->references('id')->on('nationalities')->onUpdate('cascade');
            $table->foreign('blood_type_mother')->references('id')->on('bloods')->onUpdate('cascade');
            $table->foreign('religion_mother')->references('id')->on('religions')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_parents');
    }
}
