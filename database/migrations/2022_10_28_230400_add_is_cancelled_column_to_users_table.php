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
            $table->longText('cancellation_note')->default(NULL)->nullable()->after('admission_processed_by'); 
            $table->text('cancelled_at')->default(NULL)->nullable()->after('admission_processed_by')->comment('datetime when admission cancelled');
            $table->bigInteger('cancelled_by')->default(0)->after('admission_processed_by')->comment('Admin id who cancelled the admission'); 
            $table->tinyInteger('is_cancelled')->default(0)->after('admission_processed_by')->comment('0 for not cancelled | 1 for cancelled');
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
            $table->dropColumn('cancellation_note');
            $table->dropColumn('cancelled_at');
            $table->dropColumn('cancelled_by');
            $table->dropColumn('is_cancelled');
        });
    }
};
