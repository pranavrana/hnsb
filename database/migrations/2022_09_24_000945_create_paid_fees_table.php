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
        Schema::create('paid_fees', function (Blueprint $table) {
            $table->bigIncrements('paid_fees_id');
            $table->unsignedBigInteger('fees_master_id');
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('fee_tut')->nullable();
            $table->string('fee_lib')->nullable();
            $table->string('fee_sport_gim')->nullable();
            $table->string('fee_sport_clg')->nullable();
            $table->string('fee_clgexam_stat')->nullable();
            $table->string('fee_student_rahat')->nullable();
            $table->string('fee_clg_dev')->nullable();
            $table->string('fee_you_fas')->nullable();
            $table->string('fee_med')->nullable();
            $table->string('fee_hb_rasi')->nullable();
            $table->string('fee_union')->nullable();
            $table->string('fee_reg')->nullable();
            $table->string('fee_enroll')->nullable();
            $table->string('fee_icard')->nullable();
            $table->string('fee_uniother')->nullable();
            $table->string('fee_theal')->nullable();
            $table->string('fee_lab')->nullable();
            $table->string('fee_uni_exam_form')->nullable();
            $table->string('fee_uniexam')->nullable();
            $table->string('fee_comp')->nullable();
            $table->string('fee_ele')->nullable();
            $table->string('fee_other')->nullable();
            $table->string('scope_exam_fee')->nullable();
            $table->string('fee_late')->nullable();
            $table->string('total_fee')->nullable();
            $table->tinyInteger('is_late_fees_paid')->default(0)->comment('0 for No | 1 for Yes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_fees');
    }
};
