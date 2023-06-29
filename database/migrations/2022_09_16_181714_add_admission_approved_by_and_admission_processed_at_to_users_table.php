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
            $table->integer('admission_processed_by')->default(0)->after('is_completed_registration')->comment('Admin user id');
            $table->text('admission_processed_at')->default(NULL)->nullable()->after('is_completed_registration')->comment('datetime when admission processed');
            $table->tinyInteger('is_initial_college_fees_paid')->default(0)->after('is_completed_registration')->comment('0 for Pending | 1 for Paid | 2 for Cut Off Time Over');
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
            //
        });
    }
};
