<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommitmentYearsToStudentPersonalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::table('student_personal_info', function (Blueprint $table) {
            $table->year('commitment_behavior_year')->nullable();
            $table->year('commitment_academic_year')->nullable();
            $table->year('commitment_delay_year')->nullable();
            $table->year('commitment_fees_year')->nullable();
            $table->text('school_notes')->nullable();
$table->text('admin_notes')->nullable();
$table->text('health_notes')->nullable();
$table->text('parent_recommendations')->nullable();
        });
    }

    public function down()
    {
        Schema::table('student_personal_info', function (Blueprint $table) {
            $table->dropColumn([
                'commitment_behavior_year',
                'commitment_academic_year',
                'commitment_delay_year',
                'commitment_fees_year',
            ]);
        });
    }
}
