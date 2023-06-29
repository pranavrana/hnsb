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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('password');
            $table->string('birth_date')->nullable()->after('password');
            $table->string('caste')->nullable()->after('password');
            $table->string('aadhar_card_no')->nullable()->after('password');
            $table->string('student_photo')->nullable()->after('password');
            $table->string('student_sign')->nullable()->after('password');
            $table->string('school_name')->nullable()->after('password');
            $table->string('join_date')->nullable()->after('password');
            $table->string('leaving_date')->nullable()->after('password');
            $table->string('exam_center')->nullable()->after('password');
            $table->string('passing_year')->nullable()->after('password');
            $table->string('obtained_marks')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('birth_date');
            $table->dropColumn('caste');
            $table->dropColumn('aadhar_card_no');
            $table->dropColumn('student_photo');
            $table->dropColumn('student_sign');
            $table->dropColumn('school_name');
            $table->dropColumn('join_date');
            $table->dropColumn('leaving_date');
            $table->dropColumn('exam_center');
            $table->dropColumn('passing_year');
            $table->dropColumn('obtained_marks');
        });
    }
};
