<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('student_personal_info', function (Blueprint $table) {
            $table->id();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('mother_surname');
         
            $table->string('mother_occupation');
            $table->string('mother_education_status');
            $table->string('father_occupation');
            $table->string('father_education_status');
            $table->date('father_birthdate');
            $table->date('mother_birthdate');
            $table->string('registration_place');//محل القيد 
            $table->string('registration_number');//رقم القيد
            $table->string('national_number');//الرقم الوطني
            $table->string('grandmother_name');
            
            // الحقول الجديدة
            $table->string('civil_registry_office');  // أمانة السجل المدني
            $table->string('governorate');            // المحافظة
            $table->string('housing_sector');         // قطاع السكن
            
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
        Schema::dropIfExists('student_personal_info');
    }
}
