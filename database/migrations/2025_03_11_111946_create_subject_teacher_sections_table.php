<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTeacherSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('subject_teacher_sections', function (Blueprint $table) {
    $table->id();  // معرف الجدول
    $table->unsignedBigInteger('subject_id');  // يجب أن يكون نفس النوع من جدول subjects
    $table->unsignedBigInteger('teacher_id');
    $table->unsignedBigInteger('section_id');
    
    $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
    $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

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
        Schema::dropIfExists('subject_teacher_sections');
    }
}
