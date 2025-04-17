<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisterFieldsToStudentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->string('rtype')->nullable();
            $table->string('lastschool')->nullable();
            $table->string('rdocument')->nullable();
            $table->string('ndocument')->nullable();
            $table->string('ddocument')->nullable();
            $table->string('note_register')->nullable();
            $table->string('certificate_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('student_records', function (Blueprint $table) {
            $table->dropColumn([
                'rtype',
                'lastschool',
                'rdocument',
                'ndocument',
                'ddocument',
                'note_register',
                'certificate_number'
            ]);
        });
    }
}
