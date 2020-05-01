<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassRoll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_rolles', function (Blueprint $table) {
            $table->foreignId('student_class_id');
            $table->foreignId('roll_id');

            // Foreign KEY
            $table->foreign('student_class_id')->references('id')->on('student_classes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('roll_id')->references('id')->on('rolls')->onUpdate('cascade')->onDelete('cascade');

            //Setting the Primary KEY
            $table->primary(['student_class_id','roll_id']);

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
        Schema::dropIfExists('class_rolles');
    }
}
