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
        Schema::table('fees_masters', function (Blueprint $table) {
            $table->string('cutoff_date')->nullable()->after('total_fee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees_masters', function (Blueprint $table) {
            $table->dropColumn('cutoff_date');
        });
    }
};
