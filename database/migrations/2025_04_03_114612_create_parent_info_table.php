<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('parent_info', function (Blueprint $table) {
            $table->id();
              $table->unsignedInteger('student_id');
                    $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('father_name')->nullable();
                        $table->string('grandfather_name')->nullable();

            $table->string('father_job')->nullable();
            $table->string('father_education')->nullable();
            $table->string('father_workplace')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_firstname')->nullable();
            $table->string('mother_lastname')->nullable();

                                    $table->string('grandmother_name')->nullable();

            $table->string('mother_job')->nullable();
            $table->string('mother_education')->nullable();
            $table->string('mother_workplace')->nullable();
            $table->string('mother_phone')->nullable();
                 $table->date('father_birth_date')->nullable();
            $table->string('father_nationality')->nullable();
            $table->date('mother_birth_date')->nullable();
            $table->string('mother_nationality')->nullable();
            $table->boolean('separated')->default(false);
            $table->boolean('f_deceased')->default(false);
            $table->boolean('m_deceased')->default(false);
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
        Schema::dropIfExists('parent_info');
    }
}
