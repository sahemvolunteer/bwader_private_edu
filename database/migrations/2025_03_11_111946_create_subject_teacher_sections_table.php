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
    $table->unsignedInteger('subject_id');  // يجب أن يكون نفس النوع من جدول subjects
     $table->unsignedInteger('teacher_id');
    $table->unsignedInteger('section_id');
       //     $table->unsignedInteger('student_id'); // يجب أن يكون متطابقًا مع users.id

    $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
    $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
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
