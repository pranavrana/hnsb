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
        Schema::table('groups', function (Blueprint $table) {
            
            $table->unsignedBigInteger('course_id')->nullable()->after('group_id');
            $table->unsignedBigInteger('semester_id')->nullable()->after('course_id');
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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('course_id');
            $table->dropColumn('semester_id');
        });
    }
};
