<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name_section');
            $table->integer('status');
            $table->unsignedBigInteger('grade_id');
            $table->unsignedBigInteger('class_id');
            $table->foreign('grade_id')->references('id')->on('grades')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classrooms')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sections');
    }
}
