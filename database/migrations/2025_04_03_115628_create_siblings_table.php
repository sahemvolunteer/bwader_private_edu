<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('siblings', function (Blueprint $table) {
    $table->id();
    $table->unsignedInteger('student_id');
    $table->unsignedInteger('sibling_id');
    $table->string('relation_type')->nullable(); // مثال: "أخ", "أخت"
    $table->timestamps();

    $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('sibling_id')->references('id')->on('users')->onDelete('cascade');

    // منع تكرار العلاقة
    $table->unique(['student_id', 'sibling_id']);
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siblings');
    }
}
