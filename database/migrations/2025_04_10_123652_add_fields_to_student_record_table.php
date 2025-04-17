<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToStudentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->string('first_name'); // الاسم الأول
            $table->string('last_name');  // الكنية
            $table->boolean('active')->default(1); // الحالة (فعال)
            $table->string('pob');  // مكان الميلاد
            $table->unsignedInteger('first_class_id');
            $table->string('file')->nullable(); // الحقل لتحميل ملف PDF

        });
    }

    public function down()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('active');
            $table->dropColumn('pob');
            $table->dropColumn('first_class_id');
            $table->dropColumn('file');
        });
    }

}
