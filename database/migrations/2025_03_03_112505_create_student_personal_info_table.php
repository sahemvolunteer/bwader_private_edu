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
               // إضافة عمود student_id
            $table->unsignedInteger('student_id'); // يجب أن يكون متطابقًا مع users.id
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('national_id')->nullable();
            $table->date('form_date')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->string('identified_by')->nullable();
            $table->string('exception_reason')->nullable();
            $table->boolean('withdrawal')->default(false);
            $table->string('transfer_school')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->string('approved_mobile')->nullable();
            $table->string('custom_mobile')->nullable();
            $table->string('kinship')->nullable();
            $table->string('region')->nullable();
            $table->string('full_address')->nullable();
            $table->boolean('transport_service')->default(false);
            $table->string('subscription_type')->nullable();
            $table->string('transport_group')->nullable();
            $table->string('registration_place')->nullable();//محل القيد 
            $table->string('registration_number')->nullable();//رقم القيد
            $table->string('national_number')->nullable();//الرقم الوطني
            
            // الحقول الجديدة
            $table->string('civil_registry_office')->nullable();  // أمانة السجل المدني
            $table->string('governorate')->nullable();          // المحافظة
            $table->string('housing_sector')->nullable();         // قطاع السكن

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
