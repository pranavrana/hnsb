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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->bigIncrements('enrollment_id');
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('is_fees_paid')->default(0)->comment('o for not paid | 1 for paid');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('academic_year_id')
                ->references('academic_year_id')->on('academic_years')
                ->onDelete('cascade');
            $table->foreign('course_id')
                ->references('course_id')->on('courses')
                ->onDelete('cascade');
            $table->foreign('group_id')
                ->references('group_id')->on('groups')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('student_enrollments');
    }
};
