<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_fees', function (Blueprint $table) {
            $table->bigIncrements('admission_fees_id');
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->string('admission_fees')->nullable();
            $table->string('cutoff_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_year_id')
                ->references('academic_year_id')->on('academic_years')
                ->onDelete('cascade');
            $table->foreign('course_id')
                ->references('course_id')->on('courses')
                ->onDelete('cascade');
            $table->foreign('semester_id')
                ->references('semester_id')->on('semesters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_fees');
    }
};
